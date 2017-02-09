<?php

use Viender\Utilities\Text;

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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $genders = ['male', 'female'];
    $name = $faker->name;

    return [
        'first_name' => explode(' ', $name)[0],
        'last_name' => explode(' ', $name)[1],
        'avatar_url' => "/img/profile.jpg",
        'username' => function(array $me) {
            return Text::clean($me['first_name']) . Text::clean($me['last_name']) ;
        },
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'gender' => $faker->randomElement($genders),
        'remember_token' => str_random(10),
    ];
});