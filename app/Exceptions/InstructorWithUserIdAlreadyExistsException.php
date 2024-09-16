<?php
 
namespace App\Exceptions;
 
use Exception;
 
class InstructorWithUserIdAlreadyExistsException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
	return $arr;
    }
}
