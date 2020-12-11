<?php
declare(strict_types=1);

use App\Client;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Client::truncate();
        Transaction::truncate();
        $this->call(UsersTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
