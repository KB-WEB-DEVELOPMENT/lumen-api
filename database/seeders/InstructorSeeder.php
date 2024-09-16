<?php
 
namespace Database\Seeders;

use App\User;
use App\Instructor;
 
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
	$user1_id = User::select('id')->where('name','name-user1-instructor1')->firstOrFail();
	$user2_id = User::select('id')->where('name','name-user2-instructor2')->firstOrFail();
		
	Instructor::factory()->create([
	    'title' => 'Professor',
	    'firstname' => 'Instructor1 firstname',
	    'lastname' =>  'Instructor1 lastname',
	    'user_id' => $user1_id,
	]);
		
	Instructor::factory()->create([
	    'title' => 'Professor',
	    'firstname' => 'Instructor2 firstname',
	    'lastname' =>  'Instructor2 lastname',
	     'user_id' => $user2_id
	]);		
     }
}
