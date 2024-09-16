<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseRating>
 */
class CourseRatingFactory extends Factory
{
	/**
    * The name of the factory's corresponding model.
    *
    * @var class-string<\Illuminate\Database\Eloquent\Model>
    */
	protected $model = CourseRating::class;

    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */ 
    public function definition(): array
    {
		return [
            'rating' => fake()->numberBetween(2,5),
			'course_id' => Course::factory(),
			'student_id' => Student::factory(),
        ];
    }
}