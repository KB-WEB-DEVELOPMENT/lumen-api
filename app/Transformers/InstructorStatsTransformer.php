<?php

namespace App\Transformers;

use App\Instructor;
use App\Course;
use App\CourseRating;

use Illuminate\Support\Collection;

use League\Fractal\TransformerAbstract;

class InstructorStatsTransformer extends TransformerAbstract
{
    /**
     * Transform Instructor related data into an array
     *
     * @param Instructor $instructor
     * @return array
     */
    public function transform(Instructor $instructor)
    {
		
	$registered_courses_num  = Course::where('instructor_id',$instructor->id)->count();
		
	$instructor_courses_ids  = Course::select('id')->where('instructor_id',$instructor->id)->get();
		
	$courseRatingCollection =  CourseRating::all();
		
	$filteredRatings = $courseRatingCollection->whereIn('course_id',$instructor_courses_ids)->all();
 
	$num_students_votes = $filteredRatings->count();
 
	$average_stars_rating =  $num_students_votes == 0 ? 'unavailable' : number_format($filteredRatings->sum('rating')/$num_students_votes,1,'.','');                                                   
		
	$average_percent_rating = $num_students_votes == 0 ? 'unavailable' : round(20*$average_stars_rating);  
 		
	return [
	    'name' => $instructor->title . ' ' .  ucfirst(strtolower($instructor->lastname)),
	    'registered_courses' => $registered_courses_num,
	    'average_stars_rating' => ($average_stars_rating == 'unavailable') ? 'unavailable' : $average_stars_rating . '/5', 
            'average_percent_rating' => ($average_percent_rating == 'unavailable') ? 'unavailable' :  $average_percent_rating . '%',
	    'students_votes' => $num_students_votes,
	    'created' => date('c',$instructor->created_at),
	    'updated' => date('c',$instructor->updated_at) 	
        ];
    }
}
