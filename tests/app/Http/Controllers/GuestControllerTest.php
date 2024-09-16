<?php

namespace Tests\App\Http\Controllers;

use App\User;
use App\Instructor;
use App\Student;
use App\Course;
use App\CourseRating;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\UserFactory;
use Database\Factories\InstructorFactory;
use Database\Factories\StudentFactory;
use Database\Factories\CourseFactory;
use Database\Factories\CourseRatingFactory;

use TestCase;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GuestControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_see_instructors(): void
    {		
		DB::table('instructors')->truncate();
		
		$count = DB::table('instructors')->count();
		
		$this->assertSame(0,$count);

		Instructor::factory()->count(6)->create();	
			
		$response = $this->json('GET','api/v1/instructors');
		
		$response->assertJsonCount(6,'id');
	}
	
	public function can_see_students(): void
    {		
		DB::table('students')->truncate();
		
		$count = DB::table('students')->count();
		
		$this->assertSame(0,$count);

		Student::factory()->count(7)->create();	
			
		$response = $this->json('GET','api/v1/students');
		
		$response->assertJsonCount(7,'id');
	}
	
	public function can_see_courses(): void
    {		
		DB::table('courses')->truncate();
		
		$count = DB::table('courses')->count();
		
		$this->assertSame(0,$count);

		Course::factory()->count(8)->create();	
			
		$response = $this->json('GET','api/v1/courses');
		
		$response->assertJsonCount(8,'id');
	}
	
	public function can_see_instructors_stats(): void
    {		
		DB::table('courses_ratings')->truncate();
		DB::table('courses')->truncate();
		DB::table('instructors')->truncate();
		DB::table('students')->truncate();
		DB::table('users')->truncate();
		
		$count1 = DB::table('courses_ratings')->count();
		$count2 = DB::table('courses')->count();
		$count3 = DB::table('instructors')->count();
		$count4 = DB::table('students')->count();
		$count5 = DB::table('users')->count();
		
		$this->assertSame(0,$count1);
		$this->assertSame(0,$count2);
		$this->assertSame(0,$count3);
		$this->assertSame(0,$count4);
		$this->assertSame(0,$count5);
		
		$user1 = User::factory()->create(['name' => 'instructor1-name']);
		$user2 = User::factory()->create(['name' => 'instructor2-name']);
		$user3 = User::factory()->create(['name' => 'student1-name']);
		$user4 = User::factory()->create(['name' => 'student2-name']);
		
		$instructor1 = Instructor::factory()->create(['user_id' => $user1->id ]);
		$instructor2 = Instructor::factory()->create(['user_id' => $user2->id ]);
		
		$course1 = Course::factory()->create(['instructor_id' => $instructor1->id ]);
		$course2 = Course::factory()->create(['instructor_id' => $instructor2->id ]);

		$student1 = Student::factory()->create(['user_id' => $user3->id ]);
		$student2 = Student::factory()->create(['user_id' => $user4->id ]);
		
		$courseRating1 = CourseRating::factory()->create([
												'rating' => rand(1,5),
												'course_id' => $course1->id,
												'student_id' => $student1->id,
											]);
		
		$courseRating2 = CourseRating::factory()->create([
												'rating' => rand(1,5),
												'course_id' => $course1->id,
												'student_id' => $student2->id,
											]);
		
		$courseRating3 = CourseRating::factory()->create([
												'rating' => rand(1,5),
												'course_id' => $course2->id,
												'student_id' => $student1->id,
											]);
		
		$courseRating4 = CourseRating::factory()->create([
												'rating' => rand(1,5),
												'course_id' => $course2->id,
												'student_id' => $student2->id,
											]);

		$response = $this->json('GET', 'api/v1/instructors/stats');
		
		$response->assertJsonCount(2,'name');
	}
	
	public function can_see_single_instructor(): void
    {		
		$instructor = Instructor::factory()->create(['firstname' => 'Kâmi' ]);
				
		$response = $this->json('GET', 'api/v1/instructors', ['instructorId' => $instructor->id ]);
		
		$response->seeJson(['firstname' => 'Kâmi' ]);
	}
	
	public function can_see_single_student(): void
    {	
		$student = Student::factory()->create(['firstname' => 'Kâmi' ]);
				
		$response = $this->json('GET', 'api/v1/students', ['studentId' => $student->id ]);
		
		$response->seeJson(['firstname' => 'Kâmi' ]);	
	}
	
	public function can_see_single_course(): void
    {		
		$instructor = Instructor::factory()->create();
		
		$course = Course::factory()->create([
										'title' => 'Lumen Laravel 101 - Course',
										'instructor_id' => $instructor->id,		
									]);
		
		$response = $this->json('GET', 'api/v1/courses', ['courseId' => $course->id ]);
		
		$response->seeJson(['title' => 'Lumen Laravel 101 - Course' ]);	
	}
	
	public function can_see_single_instructor_stats(): void
    {	
		$user1 = User::factory()->create();
		$user2 = User::factory()->create();
		$user3 = User::factory()->create();
		
		$instructor = Instructor::factory()->create(['user_id' => $user1->id ]);
		$student1 = Student::factory()->create(['user_id' => $user2->id ]);
		$student2 = Student::factory()->create(['user_id' => $user3->id ]);
		
		$course = Course::factory()->create(['instructor_id' => $instructor->id ]);
		
		$courseRating1 = CourseRating::factory()->create([
												'rating' => 5,
												'course_id' => $course->id,
												'student_id' => $student1->id,
											]);
											
		$courseRating2 = CourseRating::factory()->create([
												'rating' => 3,
												'course_id' => $course->id,
												'student_id' => $student2->id,
											]);
													
		$response = $this->json('GET', 'api/v1/instructors/stats', ['instructorId' => $instructor->id ]);
		
		$response->seeJson(['average_stars_rating' => 4, 'students_votes' => 2 ]);
	}
	
}	
