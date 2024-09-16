<?php

namespace Tests\App\Exceptions;

use TestCase;
use \Mockery as m;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HandlerTest extends TestCase
{
    public function responds_with_html_when_json_is_not_accepted()
    {

        $subject = m::mock(Handler::class)->makePartial();
        
        $subject->shouldNotReceive('isDebugMode');
		
	$request =  $app()->bind(
			\Illuminate\Http\Request::class,
			function () {
			    $mock = m::mock(\Illuminate\Http\Request::class)->makePartial();
			    $mock->shouldReceive('wantsJson')
				  ->andReturn(false);	
								
			    return $mock;
		        }
		    );

        $exception = m::mock(\Exception::class, ['Error!']);
        
        $exception->shouldNotReceive('getStatusCode');
        $exception->shouldNotReceive('getTrace');
        $exception->shouldNotReceive('getMessage');

        $result = $subject->render($request,$exception);

        $this->assertNotInstanceOf(JsonResponse::class,$result);
    }

    public function it_responds_with_json_for_json_consumers()
    {
        $subject = m::mock(Handler::class)->makePartial();

        $subject->shouldReceive('isDebugMode')->andReturn(false);
		
	$request =  $app()->bind(
			 \Illuminate\Http\Request::class,
			 function () {
				$mock = m::mock(\Illuminate\Http\Request::class)->makePartial();
				$mock->shouldReceive('wantsJson')
				     ->andReturn(true);	
								
				return $mock;
			  }
		    );
					
        $exception = m::mock(\Exception::class,['The exception error messsage attribute content.']);

        $exception->shouldReceive('getMessage')
                  ->andReturn('The exception error messsage attribute content.');

        $result = $subject->render($request,$exception);

        $data = $result->getData();

        $this->assertInstanceOf(JsonResponse::class,$result);
        
	$this->assertObjectHasAttribute('error',$data);
        
	$this->assertAttributeEquals('The exception error messsage attribute content.','message',$data->error);
        
	$this->assertAttributeEquals(400,'status',$data->error);
    }

    public function it_provides_json_responses_for_http_exceptions()
    {
        $subject = m::mock(Handler::class)->makePartial();

        $subject->shouldReceive('isDebugMode')
                ->andReturn(false);
				
	$request =  $app()->bind(
			  \Illuminate\Http\Request::class,
			  function () {
				$mock = m::mock(\Illuminate\Http\Request::class)->makePartial();
				$mock->shouldReceive('wantsJson')
				     ->andReturn(true);	
								
				return $mock;
			   }
		    );

        $examples = [
            [
                'mock' => NotFoundHttpException::class,
                'status' => 404,
                'message' => 'Not Found'
            ],
            [
                'mock' => AccessDeniedHttpException::class,
                'status' => 403,
                'message' => 'Forbidden'
            ],
            [
                'mock' => ModelNotFoundException::class,
                'status' => 404,
                'message' => 'Not Found'
            ]
        ];

        foreach ($examples as $e) {
            
            $exception = m::mock($e['mock']);
        
	    $exception->shouldReceive('getMessage')->andReturn(null);
            
	    $exception->shouldReceive('getStatusCode')->andReturn($e['status']);

            $result = $subject->render($request,$exception);
            
	    $data = $result->getData();

            $this->assertEquals($e['status'],$result->getStatusCode());
            
	    $this->assertEquals($e['message'],$data->error->message);
            
	    $this->assertEquals($e['status'],$data->error->status);
        }
    }
}
