<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Club;
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

$factory->define(Club::class, function (Faker $faker) {
    return [
        'user_id' => 2,
        'name'=> 'XR OS 6 iron',
        'vendor'=>'Callaway',
        'loft'=> 28.0,
        'lie'=> 62.00,
        'length'=> 37.875,
        'swing_weight'=> 'D0',
                      
    ];
});