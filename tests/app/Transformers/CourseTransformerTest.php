<?php

namespace Tests\App\Transformers;

use TestCase;

use App\Course;

use App\Transformers\CourseTransformer;

use App\Database\Factories\CourseFactory;

use League\Fractal\TransformerAbstract;
use Laravel\Lumen\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function can_be_initialized(): void
    {
        $transformer = new CourseTransformer();
        
        $this->assertInstanceOf(TransformerAbstract::class,$transformer);
    }

    public function can_transform__course_model(): void
    {
        $course = Course::factory()->make();
        
        $transformer = new CourseTransformer();

        $transformerArray = $transformer->transform($course);

        $this->assertArrayHasKey('id',$transformerArray);

        $this->assertArrayHasKey('title',$transformerArray);
        
        $this->assertArrayHasKey('topic',$transformerArray);
        
        $this->assertArrayHasKey('start_date',$transformerArray);
		
	$this->assertArrayHasKey('total_number_hours',$transformerArray);
		
	$this->assertArrayHasKey('instructor_name',$transformerArray);
		
	$this->assertArrayHasKey('created',$transformerArray);
		
	$this->assertArrayHasKey('updated',$transformerArray);
    }
}
