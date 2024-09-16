<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
	/**
    * The name of the factory's corresponding model.
    *
    * @var class-string<\Illuminate\Database\Eloquent\Model>
    */
	protected $model = Course::class;

    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */
	
    public function definition(): array
    {
        return [
			'title' => fake()->words(5,true),
			'topic'  =>  fake()->randomElement(['PHP','C++','Java']),
            'start_date' => fake()->iso8601(),
			'total_number_hours'  => fake()->numberBetween(50,100),
			'instructor_id' => Instructor::factory(),
        ];
    }
}
