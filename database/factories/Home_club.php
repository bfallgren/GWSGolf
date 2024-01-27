<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Home_club;
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

$factory->define(Home_club::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'course_id' => 1,
        'daily_fee' => $faker->randomNumber(6),
        'annual_user_fee' => $faker->randomNumber(6),
        'single_member_fee' => $faker->randomNumber(6),
        'trail_fee' => $faker->randomNumber(6),
        
        
    ];
});