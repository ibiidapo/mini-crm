<?php
declare(strict_types=1);

use App\User;
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

/** @var $factory \Faker\Factory */
$factory->define(User::class, function (Faker $faker) {
    return [
            'name'              => $faker->name,
            'email'             => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token'    => str_random(10),
            'is_admin'          => 0,
    ];
});

$factory->state(User::class, 'admin', [
        'is_admin' => 1,
]);

$factory->state(User::class, 'deleted', function (Faker $faker) {
    return [
            'deleted_at' => $faker->dateTime(),
    ];
});