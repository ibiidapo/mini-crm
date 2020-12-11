<?php
declare(strict_types=1);

use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Illuminate\Database\Eloquent\Model;

/**
 * A shorthand version of faker factory create
 *
 * @param string     $class
 * @param array|null $attributes
 * @param int|null   $counter
 * @param array|null $states
 *
 * @return Model|\Illuminate\Database\Eloquent\Collection
 */
function create(string $class, ?array $attributes = null, ?int $counter = null, ?array $states = null)
{
    if (is_array($states)) {
        return factory($class, $counter)
                ->states($states ?? [])
                ->create($attributes ?? []);
    }
    return factory($class, $counter)->create($attributes ?? []);
}

/**
 * A shorthand version of faker factory make
 *
 * @param string     $class
 * @param array|null $attributes
 * @param int|null   $counter
 * @param array|null $states
 *
 * @return Model|\Illuminate\Database\Eloquent\Collection
 */
function make(string $class, ?array $attributes = null, ?int $counter = null, ?array $states = null)
{
    if (is_array($states)) {
        return factory($class, $counter)
                ->states($states ?? [])
                ->make($attributes ?? []);
    }
    return factory($class, $counter)->make($attributes ?? []);
}

/**
 * Create user and associate transactions,10 by default
 *
 * @param int        $users
 * @param int        $transactions
 * @param array|null $attributes
 *
 * @return mixed
 */
function createUsersWithTransactions(int $users = 10, int $transactions = 10, ?array $attributes = null)
{
    return create(App\User::class, $attributes, $users)->each(function (App\User $user) use ($transactions) {
        $user->transactions()
             ->save(create(App\Transaction::class, ['user_id' => $user->id], $transactions));
    });
}

/**
 * Get fake image generator for generating fake images
 */
function fakeImageGenerator()
{
    $faker = Faker\Factory::create();
    $faker->addProvider(new ImagesGeneratorProvider($faker));
    return $faker;
}