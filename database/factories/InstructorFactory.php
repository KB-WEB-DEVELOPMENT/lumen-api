<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
 
/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
*/

class InstructorFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var class-string<\Illuminate\Database\Eloquent\Model>
    */

    protected $model = Instructor::class;
 
    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */ 
    
    public function definition(): array
    {
        return [
	   'title' =>  fake()->randomElement([
				'Associate Professor',
				'Teaching assistant',
				'Professor',
				'Adjunct professor',
				'Instructor',
				'Clinical professor',
				'Distinguished Professor',
				'Professor Emeritus',
				'Professor of Practice',
				'Research associate',
				'Tenure track',
				'Lecturer',
				'Visiting Assistant Professor'
			 ]),
            'firstname' => fake()->name(),
            'lastname'  => fake()->name(),
	    'user_id'   => User::factory(),
        ];
    }
}
