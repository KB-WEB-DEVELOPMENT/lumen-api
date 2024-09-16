<?php
 
namespace App\Exceptions;
 
use Exception;
 
class StudentReservedAccessOnlyException extends Exception
{
    public function context(): array
    {
        $arr = [];
		
	return $arr;
    }
}
