<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Golfer extends Model
{
    public function clubs()
    {
    	return $this->hasMany(Club::class);
    }

    public function scores()
    {
    	return $this->hasMany(Score::class);
    }
}
