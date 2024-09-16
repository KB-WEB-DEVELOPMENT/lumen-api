<?php

namespace Tests\App\Transformers;

use TestCase;

use App\Instructor;

use App\Transformers\InstructorTransformer;

use App\Database\Factories\InstructorFactory;

use League\Fractal\TransformerAbstract;
use Laravel\Lumen\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_be_initialized(): void
    {
        $transformer = new InstructorTransformer();
        
        $this->assertInstanceOf(TransformerAbstract::class,$transformer);
    }

    public function can_transform__instructor_model(): void
    {
        $instructor = Instructor::factory()->make();
        
        $transformer = new InstructorTransformer();

        $transformerArray = $transformer->transform($instructor);

        $this->assertArrayHasKey('id',$transformerArray);

        $this->assertArrayHasKey('title',$transformerArray);
        
        $this->assertArrayHasKey('firstname',$transformerArray);
        
        $this->assertArrayHasKey('lastname',$transformerArray);
        
        $this->assertArrayHasKey('created',$transformerArray);
        
        $this->assertArrayHasKey('updated',$transformerArray);
    }
}