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
    public function test_as_sadmin_want_to_setup_accounts()
    {

        $user = factory(User::class)->create(['roleID'=>5]);

        //this test creates a sysadmin, then he will create 3 different account
        //at this point we assert that each created account has access to the platform

        $this->browse(function ($browser) use($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
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
