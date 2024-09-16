<?php

namespace Tests\App\Http\Controllers;

use App\User;
use App\Instructor;
use App\Course;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\UserFactory;
use Database\Factories\InstructorFactory;
use Database\Factories\CourseFactory;

use TestCase;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class InstructorControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_update_self_instructor(): void
    {					
		$user = User::factory()->create();
			
		$instructor = Instructor::factory()->create(['user_id' => $user->id ]);
									
		$updated_at_value_before_update = $instructor->updated_at;				

        $this->actingAs($user)->json('PUT', 'api/v1/instructors/update');				
    
		$updated_at_value_after_update = $instructor->updated_at;
	
		$diff = $updated_at_value_after_update - $updated_at_value_before_update;
	
		$this->assertGreaterThan(0,$diff);          				
    }

	public function can_delete_self_instructor(): void
    {					
		DB::table('instructors')->truncate();
		
		$count1 = DB::table('instructors')->count();
		
		$this->assertSame(0,$count1);
		
		$user = User::factory()->create();
		
		$instructor = Instructor::factory()->create(['user_id' => $user->id ]);
		
		$count2 = DB::table('instructors')->count();
		
		$this->assertSame(1,$count2);
		
		$this->actingAs($user)->json('DELETE', 'api/v1/instructors/delete');       				
    
		$count3 = DB::table('instructors')->count();
		
		$this->assertSame(0,$count3);      				
    }

	public function can_create_own_course(): void
    {					
		DB::table('courses')->truncate();
		
		$count1 = DB::table('courses')->count();
		
		$this->assertSame(0,$count1); 
		
		$user = User::factory()->create();
					
		$this->actingAs($user)->call('POST', 'api/v1/courses/create');
		
		$count2 = DB::table('courses')->count();
		
		$this->assertSame(1,$count2); 
    }	

	public function can_update_own_course(): void
    {					
		$user = User::factory()->create();
			
		$instructor = Instructor::factory()->create(['user_id' => $user->id ]);
			
		$course = Course::factory()->create([
							'title' => 'testing update course',
							'instructor_id' => $instructor->id 
						]);
						
		$updated_at_value_before_update = $course->updated_at;				

        $this->actingAs($user)->json('PUT', 'api/v1/courses/update', ['courseId' => $course->id ]);				
    
		$updated_at_value_after_update = $course->updated_at;
	
		$diff = $updated_at_value_after_update - $updated_at_value_before_update;
	
		$this->assertGreaterThan(0,$diff);  
	}

	public function can_delete_own_course(): void
    {					
		DB::table('courses')->truncate();
		
		$count1 = DB::table('courses')->count();				
				
		$this->assertSame(0,$count1);
		
		$user = User::factory()->create();
			
		$instructor = Instructor::factory()->create(['user_id' => $user->id ]);
			
		$course = Course::factory()->create([
							'title' => 'testing delete course',
							'instructor_id' => $instructor->id 
						]);
						
		$count2 = DB::table('courses')->count();				
				
		$this->assertSame(1,$count2);
		
		$this->actingAs($user)->json('DELETE', 'api/v1/courses/delete', ['courseId' => $course->id ]);       				
    
		$count3 = DB::table('courses')->count();
		
		$this->assertSame(0,$count3);
	}	
}	