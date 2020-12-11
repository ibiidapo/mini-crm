<?php
declare(strict_types=1);

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 20 clients with no transactions
        create(Client::class, null, 20);
    }
}
