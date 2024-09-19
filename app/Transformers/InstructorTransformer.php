<?php

namespace App\Transformers;

use App\Instructor;
use League\Fractal\TransformerAbstract;

class InstructorTransformer extends TransformerAbstract
{
    /**
     * Transform an Instructor model into an array
     *
     * @param Instructor $instructor
     * @return array
     */
    public function transform(Instructor $instructor)
    {
        return [
            'id' => $instructor->id,
            'title' => $instructor->title,
	     'firstname' => ucfirst(strtolower(trim($instructor->firstname))),
            'lastname' =>  ucfirst(strtolower(trim($instructor->lastname))),
            'created' => date('c',$instructor->created_at),
            'updated' => date('c',$instructor->updated_at)
        ];
    }
}
