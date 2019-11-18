<?php

namespace Tests\Unit;

use App\Models\Student;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_parent_can_get_just_for_his_children()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'roleId' => 3
        ]);
        $student = factory(Student::class)->create([
            'mailParent1' => $user->email,

        ]);

        $response=$this->actingAs($user)->get('/student/showmarks/1');

        var_dump($response);die;

        $response = $this->get('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }




}
