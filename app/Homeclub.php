<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homeclub extends Model
{
    
    public function users()
    {
    	return $this->belongsTo(User::class);
    } 
    
    public function courses()
    {
    	return $this->belongsTo(Course::class);
    }
}
