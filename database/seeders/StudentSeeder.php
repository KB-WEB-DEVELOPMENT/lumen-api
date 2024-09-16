<?php
 
namespace Database\Seeders;

use App\User;
use App\Student;
 
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $user3_id = User::select('id')->where('name','name-user3-student1')->firstOrFail();
	$user4_id = User::select('id')->where('name','name-user4-student2')->firstOrFail();
		
	Student::factory()->create([
			'firstname' => 'Student1 firstname',
			'lastname' =>  'Student1 lastname',
			'user_id' => $user3_id,
	]);
		
	Student::factory()->create([
			'firstname' => 'Student2 firstname',
			'lastname' =>  'Student2 lastname',
			'user_id' => $user4_id
	]);		
     }
}
