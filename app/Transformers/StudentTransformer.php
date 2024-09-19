<?php

namespace App\Transformers;

use App\Student;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{
    /**
     * Transform a Student model into an array
     *
     * @param Student $student
     * @return array
     */
    public function transform(Student $student)
    {
        return [
            'id' => $student->id,
            'firstname' => ucfirst(strtolower(trim($student->firstname))),
            'lastname' =>  ucfirst(strtolower(trim($student->lastname))),
            'created' => date('c',$student->created_at),
            'updated' => date('c',$student->updated_at)
        ];
    }
}
