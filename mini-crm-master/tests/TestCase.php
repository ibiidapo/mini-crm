<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    public function signIn()
    {
        $this->be(create(User::class));
        $this->assertAuthenticated();
        return $this;
    }
    
    public function signInAdmin()
    {
        $this->be($user = create(User::class, ['is_admin' => 1]));
        return $this;
    }
}
