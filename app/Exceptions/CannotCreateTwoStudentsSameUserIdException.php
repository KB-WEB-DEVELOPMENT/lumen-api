<?php
 
namespace App\Exceptions;
 
use Exception;
 
class CannotCreateTwoStudentsSameUserIdException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
		return $arr;
    }
}