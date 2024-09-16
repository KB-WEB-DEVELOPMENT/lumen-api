<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

use App\Instructor;
use App\Course;

use App\Transformers\InstructorTransformer;
use App\Transformers\CourseTransformer;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function __construct()
    {
    }

    public function updateProfile(Request $request)
    {
        $this->validateProfile($request);
		 
	$user_id = Auth::id();
		
	$instructor = Instructor::where('user_id',$user_id)->firstOrFail();
						
	$instructor->fill($request->all());
 
	$instructor->save();
 
	$data = $this->item($instructor, new InstructorTransformer());
 		
	return response()->json($data,200);	
    }

    public function deleteProfile()
    {
        $user_id = Auth::id();
		
	$instructor = Instructor::where('user_id',$user_id)->firstOrFail();
		
	$instructor->delete();
		
	return response(null, 204);
    }

    public function createCourse(Request $request)
    {
        $this->validateCourse($request);
		
	$user_id = Auth::id();
		
	$instructor = Instructor::where('user_id',$user_id)->firstOrFail();
		
	$course = Course::create([
			'title' => $request->input('title'),
			'topic' => $request->input('topic'),
			'start_date' => $request->input('start_date'),
			'total_number_hours' => $request->input('total_number_hours'),
			'instructor_id' => $instructor->id,
		]);
		
	$data = $this->item($course, new CourseTransformer());	

	return response()->json($data, 201, [
		'Location' => route('courses.show', ['courseId' => $course->id])
	]);		
    }

    public function updateCourse(Request $request, int $courseId)
    {
        $this->validateCourse($request);
		
	$user_id = Auth::id();
		
	$instructor = Instructor::where('user_id',$user_id)->firstOrFail();
		
	$course = Course::where('instructor_id',$instructor->id)->findOrFail($courseId);
						
	$course->fill($request->all());
 
	$course->save();
 
	$data = $this->item($course, new CourseTransformer());
 		
	return response()->json($data,200);		
    }
	
    public function deleteCourse(int $courseId)
    {
        $user_id = Auth::id();
		
	$instructor = Instructor::where('user_id',$user_id)->firstOrFail();
		
	$course = Course::where('instructor_id',$instructor->id)->findOrFail($courseId);
		
	$course->delete();
		
	return response(null, 204);		
    }
	
    private function validateProfile(Request $request)
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
	
    private function validateCourse(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:1|max:100',
            'topic' => [
			'required',
			 Rule::in(['PHP','C++','Java']),
	     ],
	     'start_date' => 'required|date_format:d-m-Y|after:today',
	     'total_number_hours'  => 'required|integer|gte:1',
	]);		  
    }	
}
