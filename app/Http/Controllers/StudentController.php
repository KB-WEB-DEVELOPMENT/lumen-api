<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Student;
use App\Course;

use App\Transformers\StudentTransformer;
use App\Transformers\CourseTransformer;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function __construct()
    {
    }

     public function updateProfile(Request $request)
     {
        $this->validateProfile($request);
		 
	$user_id = Auth::id();
		
	$student = Student::where('user_id',$user_id)->firstOrFail();
						
	$student->fill($request->all());
 
	$student->save();
 
	$data = $this->item($student, new StudentTransformer());
 		
	return response()->json($data,200);
    }
	
    public function deleteProfile()
    {
        $user_id = Auth::id();
		
	$student = Student::where('user_id',$user_id)->firstOrFail();
		
	$student->delete();
		
	return response(null, 204);
    }
	
    public function createCourseRating(Request $request, int $courseId)
    {
        $this->validateCourseRating($request);
		
	$user_id = Auth::id();
		
	$student = Student::where('user_id',$user_id)->firstOrFail();
		
	$course = Course::where('id',$courseId)->firstOrFail();
		
	$courseRating = CourseRating::create([
			  'rating' => $request->input('rating'),
			  'course_id' => $course->id,
			  'student_id' => $student->id,
	]);
		
	$instructor = $course->instructor;
		
        $data = $this->item(Instructor::findOrFail($instructor->id), new InstructorStatsTransformer());

	return response()->json($data, 201, [
	    'Location' => route('instructorStats.show', ['instructorId' => $instructor->id])
	]);		
    
     }
	
     private function validateProfile(Request $request)
     {
        $this->validate($request, [
		  'firstname' => 'required|string|min:1|max:50',
		  'lastname' =>  'required|string|min:1|max:50',
        ]); 		
     }
	
     private function validateCourseRating(Request $request)
     {
        $this->validate($request, [
		   'rating' => 'required|integer|between:1,5',
        ]);  	  	  
     }
}
