<?php
declare(strict_types=1);

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 1 admin user for login
        create(User::class, [
                'name'     => 'Administrator',
                'is_admin' => 1,
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
        ]);
        
        //create 5 random users - not admins
        create(User::class, null, 5);
        
        //create 5 random users - admins
        create(User::class, null, 5, ['admin']);
    }
}
