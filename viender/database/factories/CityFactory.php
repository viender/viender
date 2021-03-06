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
$factory->define(\Viender\Address\Models\City::class, function (Faker\Generator $faker) {

    $states = \Viender\Address\Models\State::all()->pluck('id')->toArray();

    return [
        'state_id' => $faker->randomElement($states),
        'country_id' => function(array $me) {
            return \Viender\Address\Models\State::find($me['state_id'])->country()->first()->id;
        },
        'name' => $faker->city,
    ];
});
