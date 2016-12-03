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

/**
 * Account factory
 **/
$factory->define(App\Models\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'type' => array_rand(App\Models\Account::TYPES),
        'status' => 'ACTIVE',
        'is_system_account' => false,
        'xero_id' => $faker->uuid
    ];
});

/**
 * Projected Journal factory
 **/
$factory->define(App\Models\ProjectedJournal::class, function (Faker\Generator $faker) {
    return [
        'date' => $faker->date,
        'source_type' => array_rand(App\Models\ProjectedJournal::SOURCE_TYPES),
    ];
});

/**
 * User factory
 **/
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
