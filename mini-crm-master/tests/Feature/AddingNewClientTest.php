<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Client;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class AddingNewClientTest
 *
 * @coversDefaultClass \App\Http\Controllers\ClientsController
 * @package Tests\Feature
 */
class AddingNewClientTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * Test that guest users cannot create client and is redirected to login
     * @covers ::create
     */
    public function test_guest_user_cannot_create_client_redirected_to_login(): void
    {
        $this->get(route('clients.create'))
             ->assertRedirect('/login');
    }
    
    /**
     * Test that auth users can create client
     * @covers ::create
     */
    public function test_auth_user_can_create_client_and_view_form(): void
    {
        $this->signIn();
        $this->get(route('clients.create'))
             ->assertSeeText('Create');
    }
    
    /**
     * @covers ::store
     */
    public function test_client_first_name_is_required(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->signIn();
        $client = make(Client::class)
                ->setAppends([])
                ->toArray();
        array_forget($client, 'first_name');
        $this->post('/clients', $client)
             ->assertSessionHasErrors('first_name');
        $this->assertDatabaseMissing('clients', $client);
        
    }
    
    
    /**
     * @covers ::store
     */
    public function test_client_last_name_is_required(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->signIn();
        $client = make(Client::class)
                ->setAppends([])
                ->toArray();
        array_forget($client, 'last_name');
        $this->post('/clients', $client)
             ->assertSessionHasErrors('last_name');
        $this->assertDatabaseMissing('clients', $client);
        
    }
    
    
    /**
     * @covers ::store
     */
    public function test_client_email_is_required(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->signIn();
        $client = make(Client::class)
                ->setAppends([])
                ->toArray();
        array_forget($client, 'email');
        $this->post('/clients', $client)
             ->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('clients', $client);
        
    }
    
    
    /**
     * @covers ::store
     */
    public function test_client_avatar_is_required(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->signIn();
        $client = make(Client::class)
                ->setAppends([])
                ->toArray();
        array_forget($client, 'avatar');
        $this->post('/clients', $client)
             ->assertSessionHasErrors('avatar');
        $this->assertDatabaseMissing('clients', $client);
        
    }
}
