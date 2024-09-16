<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    *
    * @var class-string<\Illuminate\Database\Eloquent\Model>
    */

    protected $model = Student::class;
 
    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */
	
    public function definition(): array
    {
        return [
            'firstname' => fake()->name(),
            'lastname'  => fake()->name(),
	    'user_id' => User::factory(),
        ];
    }
}
