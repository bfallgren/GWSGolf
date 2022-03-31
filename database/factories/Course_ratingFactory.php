<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Course_rating;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Course_rating::class, function (Faker $faker) {
    return [
        'course_id' => 1,
        'tee' => $faker->safeColorName,
        'slope' => $faker->randomNumber(3),
        'rating' => $faker->randomNumber(3),
        
        
    ];
});