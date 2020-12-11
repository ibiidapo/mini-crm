<?php
declare(strict_types=1);

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    $dir  = storage_path('app/public/avatars');
    $name = fakeImageGenerator()->imageGenerator($dir, 200, 200, $faker->randomElement(['png', 'jpg', 'bmp']), false, 'Fake', $faker->hexColor, $faker->hexColor);
    return [
            'first_name'  => $faker->firstName,
            'last_name'   => $faker->lastName,
            'email'       => $faker->unique()->safeEmail,
            'avatar_path' => '/storage/avatars/' . $name,
    ];
});

$factory->state(Client::class, 'deleted', function (Faker $faker) {
    return [
            'deleted_at' => $faker->dateTime(),
    ];
});