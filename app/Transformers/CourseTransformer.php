<?php

namespace App\Transformers;

use App\Course;
use App\Instructor;
use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{
    /**
     * Transform a Course model into an array
     *
     * @param Course $course
     * @return array
     */
    public function transform(Course $course)
    {
		return [
            'id' => $course->id,
            'title' => $course->title,
            'topic' => $course->topic, 
            'start_date' => date("DD/MM/YY",strtotime($course->start_date)), // 30/06/2025 
            'total_number_hours' => $course->total_number_hours, 
            'instructor_name' => $course->instructor->title . ' ' .  ucfirst(strtolower(trim($course->instructor->lastname))),
			      'created' => $course->created_at,
			      'updated' => $course->updated_at
		];
    }
}
