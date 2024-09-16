<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instructor extends User
{  
	protected $table = 'instructors';
	/**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['title','firstname','lastname','user_id'];
	
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
	
	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id');
    }
}	
