<?php
 
namespace App\Exceptions;
 
use Exception;
 
class StudentDuplicateNameException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
	return $arr;
    }
}
