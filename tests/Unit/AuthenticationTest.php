<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }


    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'roleId' => 1
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }


    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'roleId'=>2
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }


    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'roleId'=>1
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember_token' => $user->remember_token,
        ]);

        $response->assertRedirect('/home');
        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }
    public function test_user_can_logout()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'roleId'=>2
        ]);

        $response=$this->actingAs($user)->post('/logout');


        $response->assertRedirect('/home');

        $this->assertGuest();
    }

    public function test_user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

        $token = \DB::table('password_resets')->first();
        // assertions go here
        $this->assertNotNull($token);
    }



}
