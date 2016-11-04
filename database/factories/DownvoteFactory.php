<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Downvote::class, function (Faker\Generator $faker) {

    $users = App\User::all()->pluck('id')->toArray();

    $downvotables = [
        'App\Question',
        'App\Answer',
        'App\Comment',
    ];

    return [
        'user_id' => $faker->randomElement($users),
        'downvotable_type' => $faker->randomElement($downvotables),
        'downvotable_id' => function(array $me) {
            return $faker->randomElement($me['downvotable_type']::all()->pluck('id')->toArray());
        },
    ];
});