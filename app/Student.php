<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends User
{
     protected $table = 'students';
    
     /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    
     protected $fillable = ['firstname', 'lastname','user_id'];
	
     public function user(): BelongsTo
     {
        return $this->belongsTo(User::class,'id');
     }
}
