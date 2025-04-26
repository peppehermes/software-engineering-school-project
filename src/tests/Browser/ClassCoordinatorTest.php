<?php

namespace Tests\Browser;

use App\Http\Middleware\ClassCoordinator;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;


class ClassCoordinatorTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    //this method will create a ClassCoordinator, assign him to a class with a query, and log in with credentials
    public function login_form(){

        $user = factory(User::class)->create(['roleID'=>4]);
        Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        Teacher::saveTeaching(['idTeach'=>1,'idClass'=>'1A','subject'=>'Math']);

        DB::table('class_coordinator')->insert(
            array(
                ['idTeach' => 1, 'idClass' => '1A']
            )
        );

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });

    }

    //insert final grades through class coordinator panel
    public function test_as_class_coordinator_want_insert_final_grades()
    {
        $today = now();

        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo','classID' =>'1A', 'mailParent1'=>'parent@test.com']);

        $this->login_form();

        $this->browse(function ($browser) {

            $browser->visit('/finalgrades/insert')
                ->select('frm11[finalgrade]',6)  //finalgrade of student number 1 related to subjects number 1
                ->press('Submit');
            $browser->acceptDialog()
                ->assertPathIs('/finalgrades/show')
                ->logout();

        });

        $this->assertDatabaseHas('final_grades', [
            'idStudent' => $studentid,
            'idSubject' => 1,
            'year' => $today->year,
            'idClass' => '1A',
            'finalgrade' => 6

        ]);

    }
}
