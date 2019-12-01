<?php

namespace Tests\Browser;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TeacherTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function test_as_teacher_want_insert_topics()
    {
        $today = now();
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);

        $this->browse(function ($browser) use ($user,$classid,$today){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/topic/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->select('year',$today->year)
                ->select('month',$today->month)
                ->select('day',$today->day)
                ->type('frm[topic]', 'Some topic')
                ->press('Submit')
                ->assertPathIs('/topic/list');
        });

        $this->assertDatabaseHas('lecturetopic', [
            'topic' => 'Some topic'
        ]);
    }

    public function test_as_teacher_want_insert_marks()
    {
        $today = now();
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>'parent@test.com']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);

        $this->browse(function ($browser) use ($user,$classid,$today){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/mark/add')
                ->select('idClass',$classid)
                ->select('idStudent','Giorgio Santangelo')
                ->select('subject','Math')
                ->select('mark','8')
                ->select('year',$today->year)
                ->select('month',$today->month)
                ->select('day',$today->day)
                ->type('frm[topic]', 'Some topic')
                ->press('Submit')
                ->assertPathIs('/mark/list');
        });

        $this->assertDatabaseHas('marks', [
            'mark' => 8
        ]);
    }

    public function test_as_teacher_want_publish_material()
    {

        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);



        $this->browse(function ($browser) use ($user,$classid){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/material/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('frm[mdescription]', 'Some description')
                ->attach('material',public_path('img\avatar\boy.png'))
                ->press('Submit')
                ->assertPathIs('/material/list');
        });

        $this->assertDatabaseHas('suppmaterial', [
            'mdescription' => 'Some description'
        ]);
    }

    public function test_as_teacher_want_insert_assignments()
    {
        $today = now();
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);


        $this->browse(function ($browser) use ($user,$classid,$today){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/assignment/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('frm[text]','some text')
                ->type('frm[topic]','some topic')
                ->select('year',$today->year)
                ->select('month',$today->month)
                ->select('day',$today->day)
                ->select('yeard',$today->year)
                ->select('monthd',$today->month)
                ->select('dayd',$today->day + 1)
                ->press('Submit')
                ->assertPathIs('/assignment/list');
        });

        $this->assertDatabaseHas('assignments', [
            'text' => 'some text'
        ]);
    }

    public function test_as_teacher_want_report_attendance()
    {
        $today = now();
        if($today->day <10)
            $day = '0'.$today->day;
        else
            $day = $today->day;
        $user = factory(User::class)->create(['roleID'=>2]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo','classID' =>'1A', 'mailParent1'=>'parent@test.com']);


        $this->browse(function ($browser) use ($user,$today,$day){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day)
                ->type('frm1[description]','Some description')
                ->press('Submit')
                ->assertPathIs('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day);

        });

        $this->assertDatabaseHas('student_attendance', [
            'studentId' => $studentid,
            'status' => 'absent',
            'lectureDate' => $today->year.'-'.$today->month.'-'.$day
        ]);
    }
}


