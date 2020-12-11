<?php
declare(strict_types=1);

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test for index.
     *
     * @return void
     * @throws \Throwable
     */
    public function test_index_navigates_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login');
        });
    }
    
    /**
     * A basic browser test for login using wrong credentials.
     *
     * @return void
     * @throws \Throwable
     */
    public function test_login_with_wrong_credentials()
    {
        $user = create(User::class, [
                'email'    => 'user@example.com',
                'password' => bcrypt('pass'),
        ]);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', $user->email)
                    ->type('password', 'wrong')
                    ->click('button[type="submit"]')
                    ->assertSee(trans('auth.failed'));
        });
    }
    
    /**
     * A basic browser test for login using correct credentials.
     *
     * @return void
     * @throws \Throwable
     */
    public function test_login_with_correct_credentials()
    {
        $user = create(User::class);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('#email', $user->email)
                    ->type('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee('This is a simple demo');
        });
    }
}
