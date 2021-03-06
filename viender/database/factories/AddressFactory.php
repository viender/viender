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
$factory->define(\Viender\Address\Models\Address::class, function (Faker\Generator $faker) {

    $users = App\User::all()->pluck('id')->toArray();
    $zipCodes = \Viender\Address\Models\ZipCode::all()->pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),
        'zip_code_id' => $faker->randomElement($zipCodes),
        'city_id' => function(array $me) {
            return \Viender\Address\Models\ZipCode::find($me['zip_code_id'])->city()->first()->id;
        },
        'state_id' => function(array $me) {
            return \Viender\Address\Models\ZipCode::find($me['zip_code_id'])->state()->first()->id;
        },
        'country_id' => function(array $me) {
            return \Viender\Address\Models\ZipCode::find($me['zip_code_id'])->country()->first()->id;
        },
        'active' => true,
        'street' => $faker->streetName,
    ];
});
