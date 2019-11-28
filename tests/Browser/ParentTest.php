<?php

namespace Tests\Browser;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ParentTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_as_parent_want_see_marks()
    {
        $user = factory(User::class)->create(['roleId'=>3]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);

        $this->browse(function ($browser) use ($user, $studentid){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/student/showmarks/'.$studentid)
                ->assertPresent('table');

        });
    }

    public function test_as_parent_want_download_material()
    {
        $user = factory(User::class)->create(['roleID'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);


        $this->browse(function ($browser) use ($teacher,$classid){
            $browser->visit('/login')
                ->type('email', $teacher->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/material/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('frm[mdescription]', 'Some description')
                ->attach('material',public_path('img\avatar\boy.png'))
                ->press('Submit')
                ->assertPathIs('/material/list')
                ->logout();




        });

        $this->browse(function ($browser1) use ($user, $studentid){
            $browser1->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser1->visit('/material/listforparents/'.$studentid)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.description','Some description');

        });
    }
}
