<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SysAdminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    //this method will create a systemadmin and log in with credentials
    public function login_form(){

        $user = factory(User::class)->create(['roleID'=>5]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });

    }

    public function test_as_sadmin_want_to_setup_accounts()
    {



        //this test creates a sysadmin, then he will create 3 different account
        //at this point we assert that each created account has access to the platform

        $this->login_form();

        $this->browse(function ($browser)  {
            $browser->visit('/user/add')
                    ->type('frm[name]','Gastani Frinzi')
                    ->type('frm[email]','teacher@test.com')
                    ->select('frm[roleId]','2')
                    ->select('frm[status]','Enable User')
                    ->type('frm[password]','password')
                    ->type('confirm_password','password')
                    ->press('Submit')

                    ->visit('/user/add')
                    ->type('frm[name]','Signor Rezzonico')
                    ->type('frm[email]','principal@test.com')
                    ->select('frm[roleId]','6')
                    ->select('frm[status]','Enable User')
                    ->type('frm[password]','password')
                    ->type('confirm_password','password')
                    ->press('Submit')

                    ->visit('/user/add')
                    ->type('frm[name]','Signor Gervasoni')
                    ->type('frm[email]','officer@test.com')
                    ->select('frm[roleId]','1')
                    ->select('frm[status]','Enable User')
                    ->type('frm[password]','password')
                    ->type('confirm_password','password')
                    ->press('Submit')

                    ->logout();


            $browser->visit('/login')
                ->type('email', 'teacher@test.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();

            $browser->visit('/login')
                ->type('email', 'principal@test.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();

            $browser->visit('/login')
                ->type('email', 'officer@test.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();

        });

    }
}
