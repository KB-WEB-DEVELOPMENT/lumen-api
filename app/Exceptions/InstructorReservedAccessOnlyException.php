<?php
 
namespace App\Exceptions;
 
use Exception;
 
class InstructorReservedAccessOnlyException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
	return $arr;
    }
}
