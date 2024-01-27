<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function course_ratings()
    {
    	return $this->hasMany(Course_rating::class);
    }

    public function homeclubs()
    {
    	return $this->hasMany(Home_club::class);
    }
}
