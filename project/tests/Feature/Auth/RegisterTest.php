<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{

    /** @test  */
    public function shouldHaveCorrectRegisterUrl()
    {
        $this->get(route('register'))
             ->assertStatus(200);
    }

    /** @test */
    public function shouldntRegisterWhenMissingOrInvalidData()
    {
        $userWithoutNameAndEmail = [
            'name' => '',
            'email' => '',
            'password' => 'secret01',
            'password_confirmation' => 'secret02',
            '_token' => csrf_token(),
        ];

        $this->call('POST', route('register'), $userWithoutNameAndEmail)
             ->assertSessionHasErrors('name')
             ->assertSessionHasErrors('email')
             ->assertSessionHasErrors('password');

        $userWithoutNameAndEmail['password'] = '';
        $this->call('POST', route('register'), $userWithoutNameAndEmail)
             ->assertSessionHasErrors('password');

        $userWithoutNameAndEmail['email'] = 'teste sem arroba';
        $this->call('POST', route('register'), $userWithoutNameAndEmail)
             ->assertSessionHasErrors('email');
    }

    /** @test */
    public function shouldRegisterWhenAllDataIsCorrect()
    {
        $user = [
            'name' => 'userTest',
            'email' => 'user@test.com',
            'password' => 'secret01',
            'password_confirmation' => 'secret01',
            '_token' => csrf_token(),
        ];

        $this->call('POST', route('register'), $user)
             ->assertRedirect(route('home'));

        $this->call('POST', '/login', $user);

        $this->assertAuthenticated();
    }
}
