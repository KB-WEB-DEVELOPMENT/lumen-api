<?php
 
namespace App\Exceptions;
 
use Exception;
 
class InstructorDuplicateNameException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
	return $arr;
    }
}
