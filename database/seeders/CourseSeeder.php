<?php
 
namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\Course;
 
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor1_id = Instructor::select('id')->where('lastname','Instructor1 lastname')->firstOrFail();
		
		Course::factory()->create([
			'title' => 'Lumen Framework - Basics',
			'topic' =>  'PHP',
			'start_date' => '2024-011-02T09:15:00+0000',
			'total_number_hours' => 55,
			'instructor_id' => $instructor1_id
		]);

		Course::factory()->create([
			'title' => 'Lumen Framework - Advanced',
			'topic' =>  'PHP',
			'start_date' => '2025-011-02T09:15:00+0000',
			'total_number_hours' => 70,
			'instructor_id' => $instructor1_id
		]);
		
	}
}