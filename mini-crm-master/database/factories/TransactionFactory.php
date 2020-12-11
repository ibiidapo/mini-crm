<?php
declare(strict_types=1);

use App\Client;
use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
            'client_id'        => create(Client::class)->id,
            'transaction_date' => $faker->dateTime(),
            'amount'           => $faker->randomFloat(8),
    ];
});

$factory->state(Transaction::class, 'deleted', function (Faker $faker) {
    return [
            'deleted_at' => $faker->dateTime(),
    ];
});

$factory->state(Transaction::class, 'without_client', [
        'client_id' => null,
]);
