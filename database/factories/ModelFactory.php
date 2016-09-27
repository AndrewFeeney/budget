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
$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'type' => array_rand(App\Account::TYPES),
    ];
});

/**
 * Reconciliation factory
 **/
$factory->define(App\Reconciliation::class, function (Faker\Generator $faker) {
    return [];
});

/**
 * Transaction factory
 **/
$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'date' => $faker->date,
        'amount' => $faker->randomFloat(2, -1000, 1000),
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
