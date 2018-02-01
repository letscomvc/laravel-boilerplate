<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function shouldHaveCorrectUrlWhenIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function shouldRedirectToLoginWhenNotAuthenticated()
    {
        $this->get(route('users.index'))
             ->assertStatus(302)
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function shouldShowErrorMessageWhenInvalidUser()
    {
        $user = [
            'email' => 'test@not.exists.com',
            'password' => '123456',
        ];

        $this->assertInvalidCredentials($user);

        $userWithoutEmail = [
            'email' => '',
            'password' => '123456',
        ];
        $this->assertInvalidCredentials($userWithoutEmail);

        $userWithoutPassword = [
            'email' => 'test@not.exists.com',
            'password' => '',
        ];
        $this->assertInvalidCredentials($userWithoutPassword);

        $this->assertGuest();
    }

    /** @test */
    public function shouldAuthenticateWhenUserExistsAndCorrectCredentials()
    {
        $credentials = [
            'email' => $this->user['email'],
            'password' => 'secret',
        ];

        $this->assertCredentials($credentials);

        $response = $this->call('POST', '/login', [
               'email' => $credentials['email'],
               'password' => $credentials['password'],
               '_token' => csrf_token()
           ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function shouldRedirectToLoginAfterLogout()
    {
        $credentials = [
            'email' => $this->user['email'],
            'password' => 'secret',
        ];

        $response = $this->call('POST', '/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            '_token' => csrf_token()
        ]);

        $this->call('POST', route('logout'), ['_token' => csrf_token()])
             ->assertRedirect('/');

        $this->assertGuest();
    }
}
