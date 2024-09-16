<?php
 
namespace Database\Seeders;

use App\CourseRating;
use App\Course;
use App\Student;

 
use Illuminate\Database\Seeder;

class CourseRatingSeeder extends Seeder
{
    public function run(): void
    {
        $course1_id = Course::select('id')->where('title','Lumen Framework - Basics')->firstOrFail();
	$course2_id = Course::select('id')->where('title','Lumen Framework - Advanced')->firstOrFail();
		
	$student1_id = Student::select('id')->where('lastname','Student1 lastname')->firstOrFail();
	$student2_id = Student::select('id')->where('lastname','Student2 lastname')->firstOrFail();
				
	CourseRating::factory()->create([
			'rating' => 3,
			'course_id' => $course1_id,
			'student_id' => $student1_id,
	]);

	CourseRating::factory()->create([
			'rating' => 5,
			'course_id' => $course2_id,
			'student_id' => $student2_id,
	]);		
    }
}
