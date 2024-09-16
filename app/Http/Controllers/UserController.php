<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Exceptions\CannotCreateTwoInstructorsSameUserIdException;
use App\Exceptions\CannotCreateTwoStudentsSameUserIdException;
use App\Exceptions\StudentWithUserIdAlreadyExistsException;
use App\Exceptions\InstructorWithUserIdAlreadyExistsException;
use App\Exceptions\InstructorDuplicateNameException;
use App\Exceptions\StudentDuplicateNameException;

use App\User;
use App\Instructor;
use App\Student;

use App\Transformers\InstructorTransformer;
use App\Transformers\StudentTransformer;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

# https://www.cloudways.com/blog/lumen-rest-api-authentication/#user-controller
class UserController extends Controller
{
    public function __construct()
    {
    }

    public function authenticate(Request $request)
    {
	 $this->validate($request, [
		  'email' => 'required|email:rfc,dns',
		  'password' => 'required'
        ]);
		
	$user = Users::where('email',$request->input('email'))->first();
     
	if (Hash::check($request->input('password'),$user->password)){
        
		$apikey = base64_encode(str_random(40));
          
		Users::where('email',$request->input('email'))->update(['api_key' => "$apikey"]);;
          
		return response()->json(['status' => 'success','api_key' => $apikey]);
		
	} else {
			
		return response()->json(['status' => 'fail'],401);
          }
    }

    public function createInstructor(Request $request)
    {
        $user_id = Auth::id();
		
	throw_if(
		Instructor::where('user_id',$user_id)->exists(),
		CannotCreateTwoInstructorsSameUserIdException::class
	);
		
	throw_if(
		Student::where('user_id',$user_id)->exists(),
		StudentWithUserIdAlreadyExistsException::class
	);
		
	$firstname = $request->input('firstname');
	$lastname = $request->input('lastname');
						
	throw_if(
		Instructor::where('firstname',$firstname)->where('lastname',$lastname)->exists(),
		InstructorDuplicateNameException::class
	);
											                                                                                                                                                                                                                                                                                                                                                       		
	$this->validateInstructorProfile($request);
		
	$instructor = Instructor::create([
			'title' => $request->input('title'),
			'firstname' => $request->input('firstname'),
			'lastname' => $request->input('lastname'),
			'user_id' => $user_id,
	]);
		
	$data = $this->item($instructor, new InstructorTransformer());	

	return response()->json($data, 201, [
		'Location' => route('instructors.show', ['instructorId' => $instructor->id])
	]);	
    
     }
	
    public function createStudent(Request $request)
    {
        $user_id = Auth::id();
		
	throw_if(
	    Student::where('user_id',$user_id)->exists(),
	    CannotCreateTwoStudentsSameUserIdException::class
	);
		
	throw_if(
	    Instructor::where('user_id',$user_id)->exists(),
	    InstructorWithUserIdAlreadyExistsException::class
        );
		
	$firstname = $request->input('firstname');
	$lastname = $request->input('lastname');
						
	throw_if(
	   Student::where('firstname',$firstname)->where('lastname',$lastname)->exists(),
	   StudentDuplicateNameException::class
	);
		
	$this->validateStudentProfile($request);
		
	$student = Student::create([
		     'firstname' => $request->input('firstname'),
		     'lastname' => $request->input('lastname'),
		     'user_id' => $user_id,
		   ]);
		
	$data = $this->item($student, new StudentTransformer());	

	return response()->json($data, 201, [
	    'Location' => route('students.show', ['studentId' => $student->id])
	]);	
    
      }
	
      private function validateInstructorProfile(Request $request)
      {
        $this->validate($request, [
            'title' => [
		         'required',
			  Rule::in([
			   'Associate Professor', 'Teaching assistant','Professor','Adjunct professor',
			   'Instructor','Clinical professor','Distinguished Professor','Professor Emeritus',
			   'Professor of Practice','Research associate','Tenure track','Lecturer',
			   'Visiting Assistant Professor',
			]),
		       ],
	     'firstname' => 'required|string|min:1|max:50',
	     'lastname' =>  'required|string|min:1|max:50',
        ]); 	  	  
       }
	
	private function validateStudentProfile(Request $request)
	{
             $this->validate($request, [
		 'firstname' => 'required|min:1|max:50',
		 'lastname' =>  'required|min:1|max:50',
             ]); 		
	}
}
