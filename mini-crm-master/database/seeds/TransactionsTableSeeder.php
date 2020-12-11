<?php
declare(strict_types=1);

use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 50 transactions with their clients, with random number additional of transactions, 1-10 transactions per client
        create(Transaction::class, null, 50)->each(function (Transaction $transaction) {
            create(Transaction::class, ['client_id' => $transaction->client_id], random_int(1, 10), ['without_client']);
        });
    }
}
