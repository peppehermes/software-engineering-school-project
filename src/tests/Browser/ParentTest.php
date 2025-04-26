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

    //this method will create a parent, assign him a student, then it will log in with credentials
    public function login_parent(){

        $user = factory(User::class)->create(['roleID'=>3]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => '1A', 'mailParent1'=>$user->email]);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);


        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });

        return $user;

    }
    //this method will create a teacher and will return its user data
    public function  create_teacher(){

        $user = factory(User::class)->create(['roleID'=>2]);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);
        return $user;

    }

    //this method will create a teacher, assign him a class and a teaching, then it will log in with credentials
    public function login_teacher($user){



        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });

    }



    public function test_as_parent_want_see_topics()
    {

        $teacher = $this->create_teacher();
        Topic::save(['idTeach'=>$teacher->id,'idClass'=>'1A','subject'=>'Math', 'date'=>'2019-12-3', 'topic'=>'Some topic']);

        $this->login_parent();

        $this->browse(function ($browser) {

            $browser->visit('/topic/listforparents/1')  //student id = 1 cause it's the first student enrolled
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.idClass','1A')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.topic','Some topic')
                ->logout();

        });
    }

    public function test_as_parent_want_see_marks()
    {
        $teacher = $this->create_teacher();
        Mark::save(['idTeach'=>$teacher->id,'idClass'=>'1A','idStudent'=>1, 'mark'=>8]);
        $this->login_parent();

        $this->browse(function ($browser) {
            $browser->visit('/student/showmarks/1')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.mark','8')
                ->logout();

        });
    }

    public function test_as_parent_want_download_material()
    {

        $teacher = $this->create_teacher();

        $this->login_teacher($teacher);

        $this->browse(function ($browser) {
            $browser->visit('/material/add')
                ->select('idClass','1A')
                ->select('subject','Math')
                ->type('frm[mdescription]', 'Some description')
                ->attach('material[]',public_path('robots.txt'))
                ->press('Submit')
                ->assertPathIs('/material/list')
                ->logout();




        });

        $this->login_parent();

        $this->browse(function ($browser1) {
            $browser1->visit('/material/listforparents/1')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.description','Some description')
                ->logout();

        });
    }

    public function test_as_parent_want_see_assignments()
    {
        $teacher = $this->create_teacher();
        Assignment::save(['idClass'=>'1A','text'=>'some text','idTeach'=>$teacher->id]);

        $this->login_parent();

        $this->browse(function ($browser) {
            $browser->visit('/assignment/listforparents/1')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.text','some text')
                ->logout();


        });
    }

    public function test_as_parent_want_see_attendance()
    {
        $today= now();
        $teacher = $this->create_teacher();

        Student::saveStudentAttendance(['studentId'=> 1 ,'teacherId' => $teacher->id, 'classId'=>'1A',
                                        'lectureDate'=>$today->year.'-'.$today->month.'-'.$today->day,'status'=>'absent',
                                        'presence_status'=>'full','description'=>'some description']);

        $this->login_parent();

        $this->browse(function ($browser) use ($today){
            $browser->visit('/student/attendance_report/1')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.status','absent')
                ->assertSeeIn('table > tbody > tr:nth-child(1) > td.desc','some description')
                ->logout();

        });
    }

    public function test_as_parent_want_see_communications()
    {
        $admin = factory(User::class)->create(['roleId'=>1]);
        Communications::addNewComm(['description'=>'Some description','idAdmin' => $admin->id]);

        $this->login_parent();

        $this->browse(function ($browser) use ($admin){
            $browser->visit('/communications/list')
                ->assertSee($admin->name)
                ->logout();

        });
    }

    public function test_as_parent_want_see_notes()
    {
        $today= now();
        $teacher= $this->create_teacher();

        Note::save(['date' => $today->year.'-'.$today->month.'-'.$today->day,
            'idClass' => '1A',
            'idStudent' => 1,
            'subject' => 'Math',
            'idTeach' => $teacher->id,
            'note' => 'This is a note']);

        $this->login_parent();

        $this->browse(function ($browser) use ($teacher, $today){
            $browser->visit('/notes/shownotes/1')
                ->assertSee('This is a note')
                ->assertSee('Math')
                ->assertSee($teacher->name)
                ->assertSee($today->year.'-'.$today->month.'-'.$today->day)
                ->logout();
        });
    }

    public function test_as_parent_want_check_timetable()
    {

        $this->create_teacher();
        $this->login_parent();

        $this->browse(function ($browser) {
            $browser->visit('/timetable/listforparents/1')
                ->assertSee('Time Table of class 1A')
                ->logout();
        });

    }

    public function test_as_parent_want_book_meetings()
    {
        $year= date('Y');
        $week= date('W') +1 ;
        $teacher = $this->create_teacher();
        //if the week number is below 10, i force the leading "0" before the digit for the form format
        if($week < 10){
            $week = '0'.$week;

        }
        // if it is the last week of the year, i force to book the second week of the new year
        if($week == 52){
            $week = "02";
            $year = $year + 1;

        }


        Meeting::save(['idTimeslot' => 1 , 'idTeacher' => 1, 'idweek' => $year.'-W'.($week)]);
        Meeting::save(['idTimeslot' => 2 , 'idTeacher' => 1, 'idweek' => $year.'-W'.($week)]);

        $user = $this->login_parent();

        $this->browse(function ($browser) use ($teacher,$week,$year){
            $browser->visit('/meetings/choose/1')
                ->select('frm[teachId]',$teacher->name)
                ->type('frm[week]','Settimana '.($week).', '.$year)
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
            'idweek' => $year.'-W'.$week,
            'isBooked' => 1,
            'idParent' => $user->id,
            'idStud' => 1
        ]);
    }

    public function test_as_parent_want_check_final_grades()
    {
        $year= date('Y');

        FinalGrades::save(['idStudent'=>1,'idSubject' =>1,'year' => $year,'idClass' => '1A', 'finalgrade' => 7]);

        $this->login_parent();

        $this->browse(function ($browser) {
            $browser->visit('/finalgrades/listforparents/1')
                ->assertSee('Final Grades for Class 1A')  //if finalgrades would've not be present, the page would've redirect to home page with an error
                ->logout();
        });

    }



}
