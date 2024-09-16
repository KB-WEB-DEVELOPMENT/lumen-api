<?php
 
namespace App\Exceptions;
 
use Exception;
 
class StudentWithUserIdAlreadyExistsException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
		return $arr;
    }
}