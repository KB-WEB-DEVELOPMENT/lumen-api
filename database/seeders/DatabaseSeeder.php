<?php
 
namespace Database\Seeders;

use App\User;
use App\Instructor;
use App\Student;
use App\Course;
use App\CourseRating;
 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
			UserSeeder::class,
			InstructorSeeder::class,
			StudentSeeder::class,
			CourseSeeder::class,
			CourseRatingSeeder::class,
		]);
    }
}
