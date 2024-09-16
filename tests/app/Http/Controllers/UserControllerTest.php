<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Support\Facades\Exceptions;

use App\Exceptions\CannotCreateTwoInstructorsSameUserIdException;
use App\Exceptions\CannotCreateTwoStudentsSameUserIdException;
use App\Exceptions\StudentWithUserIdAlreadyExistsException;
use App\Exceptions\InstructorWithUserIdAlreadyExistsException;
use App\Exceptions\InstructorDuplicateNameException;
use App\Exceptions\StudentDuplicateNameException;

use App\User;
use App\Instructor;
use App\Student;

use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\UserFactory;
use Database\Factories\InstructorFactory;
use Database\Factories\StudentFactory;

use TestCase;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

// 
class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
	
    public function can_create_own_instructor(): void
    {					
        DB::table('instructors')->truncate();
		
	$count1 = DB::table('instructors')->count();
		
	$this->assertSame(0,$count1);
		
	$user = User::factory()->create();
													
	$this->actingAs($user)->call('POST', 'api/v1/instructors/create');
		
	$count2 = DB::table('instructors')->count();
		
	$this->assertSame(1,$count2);    					
    }

    public function can_create_own_student(): void
    {		
       DB::table('students')->truncate();
		
       $count1 = DB::table('students')->count();
		
       $this->assertSame(0,$count1);
		
       $user = User::factory()->create();
													
       $this->actingAs($user)->call('POST', 'api/v1/students/create');
		
       $count2 = DB::table('students')->count();
		
       $this->assertSame(1,$count2);
    }
	
    public function fails_new_instructor_existing_instructor_user_id(): void
    {			
	Exceptions::fake();
		
	DB::table('instructors')->truncate();
		
	$count1 = DB::table('instructors')->count();
		
	$this->assertSame(0,$count1);
		
	$user = User::factory()->create();
													
	$this->actingAs($user)->call('POST', 'api/v1/instructors/create');
		
	$count2 = DB::table('instructors')->count();
		
	$this->assertSame(1,$count2);
		
	$this->actingAs($user)->call('POST', 'api/v1/instructors/create');
 
        Exceptions::assertReported(CannotCreateTwoInstructorsSameUserIdException::class);
     }
	
     public function fails_new_student_existing_student_user_id(): void
     {	
        Exceptions::fake();
		
	DB::table('students')->truncate();
		
	$count1 = DB::table('students')->count();
		
	$this->assertSame(0,$count1);
		
	$user = User::factory()->create();
													
	$this->actingAs($user)->call('POST', 'api/v1/students/create');
		
	$count2 = DB::table('students')->count();
		
	$this->assertSame(1,$count2);
		
	$this->actingAs($user)->call('POST', 'api/v1/students/create');
 
        Exceptions::assertReported(CannotCreateTwoStudentsSameUserIdException::class);
      }
	
      public function fails_new_instructor_existing_student_user_id(): void
      {	
	Exceptions::fake();
		
	$user = User::factory()->create();
				
	$student = Student::factory()->create(['user_id' => $user->id ]);
															
	$this->actingAs($user)->call('POST', 'api/v1/instructors/create');
 
        Exceptions::assertReported(StudentWithUserIdAlreadyExistsException::class);
      }
	
      public function fails_new_student_existing_instructor_user_id(): void
      { 	
         Exceptions::fake();
 
         $user = User::factory()->create();
				
	 $instructor = Instructor::factory()->create(['user_id' => $user->id ]);
															
	 $this->actingAs($user)->call('POST', 'api/v1/students/create');
 
         Exceptions::assertReported(InstructorWithUserIdAlreadyExistsException::class);
       }	

       public function fails_duplicate_instructors_names(): void
       {	
	  Exceptions::fake();
 
          $user1 = User::factory()->create();
		
	  $user2 = User::factory()->create();
		
	  $instructor1 = Instructor::factory()->create([
			'firstname' =>  'Aaaaaaa',
			'lastname ' =>  'Bbbbbbb',
			'user_id' => $user1->id,
	  ]);
		
	  $this->actingAs($user2)->call('POST', 'api/v1/instructors/create',[
					   'firstname' =>  'Aaaaaaa',
					   'lastname ' =>  'Bbbbbbb',
					   'user_id' => $user2->id, 
			               ]);
								
          Exceptions::assertReported(InstructorDuplicateNameException::class);
	
	}	

	public function fails_duplicate_students_names(): void
        {	
            $user1 = User::factory()->create();
		
	    $user2 = User::factory()->create();
		
	    $student1 = Student::factory()->create([
			'firstname' =>  'Aaaaaaa',
			'lastname ' =>  'Bbbbbbb',
			'user_id' => $user1->id,
	    ]);
		
	    $this->actingAs($user2)->call('POST', 'api/v1/students/create',[
				                'firstname' =>  'Aaaaaaa',
						'lastname ' =>  'Bbbbbbb',
 					        'user_id' => $user2->id, 
	    ]);
 
            Exceptions::assertReported(StudentDuplicateNameException::class);
	}
}	
