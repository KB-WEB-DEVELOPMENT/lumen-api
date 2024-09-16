<?php
 
namespace App\Exceptions;
 
use Exception;
 
class CannotCreateTwoInstructorsSameUserIdException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
		return $arr;
    }
}
