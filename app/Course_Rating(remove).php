<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Rating extends Model
{
    public function courses()
    {
    	return $this->belongsTo(Course::class);
    }
}
