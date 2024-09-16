<?php

namespace Tests\App\Transformers;

use TestCase;

use App\Student;

use App\Transformers\StudentTransformer;

use App\Database\Factories\StudentFactory;

use League\Fractal\TransformerAbstract;
use Laravel\Lumen\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_be_initialized(): void
    {
        $transformer = new StudentTransformer();
        
        $this->assertInstanceOf(TransformerAbstract::class,$transformer);
    }

    public function can_transform__student_model(): void
    {
        $student = Student::factory()->make();
        
        $transformer = new StudentTransformer();

        $transformerArray = $transformer->transform($student);

        $this->assertArrayHasKey('id',$transformerArray);

        $this->assertArrayHasKey('firstname',$transformerArray);
        
        $this->assertArrayHasKey('lastname',$transformerArray);
        
        $this->assertArrayHasKey('created',$transformerArray);
		
	$this->assertArrayHasKey('updated',$transformerArray);
    }
}
