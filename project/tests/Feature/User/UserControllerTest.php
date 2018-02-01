<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setup();
        $this->user = factory(User::class)->create();
        $credentials = [
            'email' => $this->user->email,
            'password' => 'secret',
        ];

        $this->call('POST', '/login', $credentials);
    }

    /** @test */
    public function shouldntCreateWhenMissingData()
    {
        $new_user_form_data = factory(User::class)->make()->toArray();
        $new_user_form_data['email'] = '';
        $new_user_form_data['name'] = '';
        $new_user_form_data['password'] = '';
        $new_user_form_data['_token'] = csrf_token();

        $this->call('POST', route('users.store'), $new_user_form_data)
             ->assertSessionHasErrors('email')
             ->assertSessionHasErrors('name')
             ->assertSessionHasErrors('password');
    }

    /** @test */
    public function shouldCreateWhenCorrectData()
    {
        $new_user_form_data = factory(User::class)->make()->toArray();
        $new_user_form_data['password'] = 'secret';
        $new_user_form_data['password_confirmation'] = 'secret';
        $new_user_form_data['_token'] = csrf_token();

        $this->call('POST', route('users.store'), $new_user_form_data)
             ->assertRedirect()
             ->assertSessionHas('success');
    }

    /** @test */
    public function shouldntUpdateWhenIncorrectData()
    {
        $user = User::first();
        $user_invalid = factory(User::class)->states('invalid')->make()->toArray();
        $user_invalid['id'] = $user->id;
        $user_invalid['_token'] = csrf_token();

        $this->call('PUT', route('users.update', $user_invalid['id']), $user_invalid)
             ->assertRedirect()
             ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function shouldUpdateWhenCorrectData()
    {
        $user = User::first()->toArray();
        $user['name'] = 'NEW NAME';
        $user['password'] = 'secret';
        $user['password_confirmation'] = 'secret';
        $user['_token'] = csrf_token();

        $this->call('PUT', route('users.update', $user['id']), $user)
             ->assertRedirect()
             ->assertSessionHas('success');
    }
}
