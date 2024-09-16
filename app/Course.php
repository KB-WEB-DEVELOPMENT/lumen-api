<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $table = 'courses';
	/**
     * The attributes that are mass assignable
     *
     * @var array
     */
	 
    protected $fillable = ['title', 'topic', 'start_date', 'total_number_hours','instructor_id'];
	
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class,'id');
    }
	
	protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('c', strtotime($value)),
            set: fn (string $value) => date('c', strtotime($value)),
        );
    }
}
