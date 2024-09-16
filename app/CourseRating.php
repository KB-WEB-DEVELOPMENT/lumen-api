<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRating extends Model
{    
	protected $table = 'courses_ratings';
	/**
     * The attributes that are mass assignable
     *
     * @var array
     */
	 
    protected $fillable = ['rating','course_id','student_id'];
	
	public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'id');
    }	

    public function student(): BelongsTo 
    {
        return $this->belongsTo(Student::class,'id');
    }		
}
