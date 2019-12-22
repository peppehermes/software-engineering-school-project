<?php

namespace Tests\Browser;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Communications;
use App\Models\FinalGrades;
use App\Models\Meeting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Mark;
use App\Models\Note;
use App\Models\Topic;
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
    public function test_as_parent_want_see_topics()
    {
        $user = factory(User::class)->create(['roleId'=>3]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>'', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Topic::save(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math', 'date'=>'2019-12-3', 'topic'=>'Some topic']);

        $this->browse(function ($browser) use ($user, $studentid,$teacher){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/topic/listforparents/'.$studentid)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.idClass','1A')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.teacherName',$teacher->name)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.topic','Some topic')
                ->logout();

        });
    }

    public function test_as_parent_want_see_marks()
    {
        $user = factory(User::class)->create(['roleId'=>3]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>$user->email]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Mark::save(['idTeach'=>$teacherid,'idClass'=>$classid,'idStudent'=>$studentid, 'mark'=>8]);

        $this->browse(function ($browser) use ($user, $studentid){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/student/showmarks/'.$studentid)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.mark','8')
                ->logout();

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
                ->attach('material[]',public_path('robots.txt'))
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
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.description','Some description')
                ->logout();

        });
    }

    public function test_as_parent_want_see_assignments()
    {
        $user = factory(User::class)->create(['roleId'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>$user->email]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Assignment::save(['idClass'=>$classid,'text'=>'some text','idTeach'=>$teacherid]);

        $this->browse(function ($browser) use ($user, $studentid){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/assignment/listforparents/'.$studentid)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.text','some text')
                ->logout();


        });
    }

    public function test_as_parent_want_see_attendance()
    {
        $today= now();
        $user = factory(User::class)->create(['roleId'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Student::saveStudentAttendance(['studentId'=> $studentid ,'teacherId' => $teacherid, 'classId'=>'1A',
                                        'lectureDate'=>$today->year.'-'.$today->month.'-'.$today->day,'status'=>'absent',
                                        'presence_status'=>'full','description'=>'some description']);

        $this->browse(function ($browser) use ($user, $studentid, $today){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/student/attendance_report/'.$studentid)
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.status','absent')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.desc','some description')
                ->logout();

        });
    }

    public function test_as_parent_want_see_communications()
    {
        $user = factory(User::class)->create(['roleId'=>3]);
        $admin = factory(User::class)->create(['roleId'=>1]);
        Communications::addNewComm(['description'=>'Some description','idAdmin' => $admin->id]);

        $this->browse(function ($browser) use ($user,$admin){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/communications/list')
                ->assertSee($admin->name)
                ->logout();

        });
    }

    public function test_as_parent_want_see_notes()
    {
        $today= now();
        $user = factory(User::class)->create(['roleId'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Note::save(['date' => $today->year.'-'.$today->month.'-'.$today->day,
            'idClass' => $classid,
            'idStudent' => $studentid,
            'subject' => 'Math',
            'idTeach' => $teacherid,
            'note' => 'This is a note']);

        $this->browse(function ($browser) use ($teacher, $user, $studentid, $today){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/notes/shownotes/'.$studentid)
                ->assertSee('This is a note')
                ->assertSee('Math')
                ->assertSee($teacher->name)
                ->assertSee($today->year.'-'.$today->month.'-'.$today->day)
                ->logout();
        });
    }
    public function test_as_parent_want_check_timetable()
    {

        $user = factory(User::class)->create(['roleID'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Teacher::save(['firstName'=>$teacher->name, 'lastName'=>' ', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        Teacher::saveTeaching(['idTeach'=>1,'idClass'=>'1A','subject'=>'Math']);

        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/timetable/listforparents/1')
                ->assertSee('Time Table of class 1A')
                ->logout();
        });

    }

    public function test_as_parent_want_book_meetings()
    {
        $year= date('Y');
        $week= date('W');
        $user = factory(User::class)->create(['roleID'=>3]);
        $teacher = factory(User::class)->create(['roleID'=>2]);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Teacher::save(['firstName'=>$teacher->name, 'lastName'=>'', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        Teacher::saveTeaching(['idTeach'=>1,'idClass'=>'1A','subject'=>'Math']);
        Meeting::save(['idTimeslot' => 1 , 'idTeacher' => 1, 'idweek' => $year.'-W'.($week+1)]);
        Meeting::save(['idTimeslot' => 2 , 'idTeacher' => 1, 'idweek' => $year.'-W'.($week+1)]);

        $this->browse(function ($browser) use ($user,$teacher,$week,$year){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/meetings/choose/1')
                ->select('frm[teachId]',$teacher->name)
                ->type('frm[week]','Settimana '.($week+1).', '.$year)
                ->press('Submit')
                ->assertPathIs('/meetings/book/1')
                ->click('@slot1')
                ->press('Book Slot')
                ->logout();
        });

        $this->assertDatabaseHas('meetings', [
            'id' => 1,
            'idTimeslot' => 1,
            'idTeacher' => 1,
            'idweek' => $year.'-W'.($week+1),
            'isBooked' => 1,
            'idParent' => $user->id,
            'idStud' => $studentid
        ]);

    }


    public function test_as_parent_want_check_final_grades()
    {
        $year= date('Y');
        $user = factory(User::class)->create(['roleID'=>3]);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        FinalGrades::save(['idStudent'=>1,'idSubject' =>1,'year' => $year,'idClass' => '1A', 'finalgrade' => 7]);

        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/finalgrades/listforparents/1')
                ->assertSee('Final Grades for Class 1A')  //if finalgrades would've not be present, the page would've redirect to home page with an error
                ->logout();
        });

    }



}
