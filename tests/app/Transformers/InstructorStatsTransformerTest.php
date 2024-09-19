<?php

namespace Tests\App\Transformers;

use TestCase;

use App\Instructor;
use App\Student;
use App\Course;
use App\CourseRating;

use App\Database\Factories\InstructorFactory;
use App\Database\Factories\StudentFactory;
use App\Database\Factories\CourseFactory;
use App\Database\Factories\CourseRatingFactory;

use App\Transformers\InstructorStatsTransformer;

use League\Fractal\TransformerAbstract;
use Laravel\Lumen\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorStatsTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_be_initialized(): void
    {
        $transformer = new InstructorStatsTransformer();
        
        $this->assertInstanceOf(TransformerAbstract::class,$transformer);
    }

    public function can_transform__instructorStats_construct(): void
    {
        $instructor = Instructor::factory()->create();
		
	$student = Student::factory()->create();
		
	$course = Course::factory()->create([
			'instructor_id' => $instructor->id,
	]);
		
	$courseRating = CourseRating::factory()->create([
			  'rating' => rand(2,5),
			  'course_id' => $course->id, 
			  'student_id' => $student->id 
	]);
						
        $transformer = new InstructorStatsTransformer();

        $transformerArray = $transformer->transform($instructor);
		
        $this->assertArrayHasKey('id',$transformerArray);

        $this->assertArrayHasKey('name',$transformerArray);
        
        $this->assertArrayHasKey('registered_courses',$transformerArray);
        
        $this->assertArrayHasKey('average_stars_rating',$transformerArray);
		
	$this->assertArrayHasKey('average_percent_rating',$transformerArray);
		
	$this->assertArrayHasKey('students_votes',$transformerArray);

	$this->assertArrayHasKey('created',$transformerArray);
		
	$this->assertArrayHasKey('updated',$transformerArray);
    }
}
