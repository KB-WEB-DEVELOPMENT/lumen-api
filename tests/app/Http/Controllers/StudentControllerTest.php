<?php

namespace Tests\App\Http\Controllers;

use App\User;
use App\Student;
use App\Course;
use App\CourseRating;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\UserFactory;
use Database\Factories\StudentFactory;
use Database\Factories\CourseFactory;
use Database\Factories\CourseRatingFactory;

use TestCase;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class StudentControllerTest extends TestCase
{
    use DatabaseMigrations;

	 public function can_update_self_student(): void
    {					
		$user = User::factory()->create();
			
		$student =  Student::factory()->create(['user_id' => $user->id ]);
									
		$updated_at_value_before_update = $student->updated_at;				

        $this->actingAs($user)->json('PUT', 'api/v1/students/update');				
    
		$updated_at_value_after_update = $student->updated_at;
	
		$diff = $updated_at_value_after_update - $updated_at_value_before_update;
	
		$this->assertGreaterThan(0,$diff);          				
    }

	public function can_delete_self_student(): void
    {					
		DB::table('students')->truncate();
		
		$count1 = DB::table('students')->count();
		
		$this->assertSame(0,$count1); 
		
		$user = User::factory()->create();
		
		$student = Student::factory()->create(['user_id' => $user->id ]);
		
		$count2 = DB::table('students')->count();
		
		$this->assertSame(1,$count2);
		
		$this->actingAs($user)->json('DELETE', 'api/v1/students/delete');       				
    
		$count3 = DB::table('students')->count();
		
		$this->assertSame(0,$count3);      				
    }
	
	public function can_create_course_rating(): void
    {							    
		
		$user = User::factory()->create();
		
		$student = Student::factory()->create(['user_id' => $user->id ]);
	
		$course = Course::factory()->create();
				
		$this->actingAs($user)->json('POST', 'api/v1/students/courses/rating', [
									        'rating' => 5, 
											'courseId' => $course->id  		 
									]);	
		
		$this->seeInDatabase('courses_ratings', [
					'rating' => 5,
					'course_id' =>  $course->id, 
					'student_id' => $student->id,
				]);
	}
}	
