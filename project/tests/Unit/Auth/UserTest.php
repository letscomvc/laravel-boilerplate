<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('migrate');
        // \Route::enableFilters();
        \Session::start();
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
        $user = [
            'name' => 'User',
            'email' => 'test@exists.com',
            'password' => \Hash::make('test'),
        ];

        User::create($user);

        $credentials = [
            'email' => $user['email'],
            'password' => 'test',
        ];


        $this->assertCredentials($credentials);

        $response = $this->call('POST', '/login', [
               'email' => $credentials['email'],
               'password' => $credentials['password'],
               '_token' => csrf_token()
           ]);

        $this->assertAuthenticated();
    }
}
