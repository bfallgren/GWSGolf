<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Score;
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

$factory->define(Score::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'course_id' => 1,
        'date_played' => date(now()),
        'score' => $faker->numberBetween(72,99),
        'tee' => $faker->safeColorName,
        'holes' => 18,
        'diff' => $faker->numberBetween(1,20),
              
    ];
});