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
        $date=$today->day.'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);

        $this->browse(function ($browser) use ($user,$classid,$date){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/topic/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('lecturedate',$date)
                ->type('frm[topic]', 'Some topic')
                ->press('Submit')
                ->assertPathIs('/topic/list')
                ->logout();
        });

        $this->assertDatabaseHas('lecturetopic', [
            'topic' => 'Some topic'
        ]);
    }

    public function test_as_teacher_want_insert_topics_wrong_date()
    {
        $today = now();
        $date=($today->day+1).'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);

        $this->browse(function ($browser) use ($user,$classid,$date){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/topic/add')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('lecturedate',$date)
                ->type('frm[topic]', 'Some topic')
                ->press('Submit');
                $browser->acceptDialog()
                ->assertPathIsNot('/topic/list')
                ->logout();
        });
    }

    public function test_as_teacher_want_insert_marks()
    {
        $today = now();
        $date=$today->day.'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>'parent@test.com']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);

        $this->browse(function ($browser) use ($user,$classid,$date){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/mark/classes')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('topic', 'Some topic')
                ->type('lecturedate',$date)
                ->press('Submit')
                ->check('frm21[status]')  //checking the checkbox of the student with id 1
                ->select('frm1[mark]','8') //assigning the mark to the student selected
                ->press('Submit')
                ->assertPathIs('/mark/classlist')
                ->logout();
        });

        $this->assertDatabaseHas('marks', [
            'idStudent' => 1,
            'Subject' => 'Math',
            'mark' => 8
        ]);
    }

    public function test_as_teacher_want_insert_mark_wrong_date()
    {
        $today = now();
        $date=($today->day+1).'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        $studentid = Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'classId' => $classid, 'mailParent1'=>'parent@test.com']);
        Student::saveStudParent(['idParent'=>$user->id,'idStudent'=>$studentid]);

        $this->browse(function ($browser) use ($user,$classid,$date){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/mark/classes')
                ->select('idClass',$classid)
                ->select('subject','Math')
                ->type('topic', 'Some topic')
                ->type('lecturedate',$date)
                ->press('Submit')
                ->acceptDialog() // "Wrong Date !" Alert
                ->logout();
        });

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
                ->attach('material[]',public_path('robots.txt'))
                ->press('Submit')
                ->assertPathIs('/material/list')
                ->logout();
        });

        $this->assertDatabaseHas('suppmaterial', [
            'mdescription' => 'Some description'
        ]);
    }

    public function test_as_teacher_want_publish_multi_material()
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
                ->attach('material[]',public_path('robots.txt'))
                ->attach('material[]',public_path('timetable.csv'))

                ->press('Submit')
                ->assertPathIs('/material/list')
                ->logout();
        });

        $this->assertDatabaseHas('suppmaterial', [
            'mdescription' => 'Some description'
        ]);
    }

    public function test_as_teacher_want_write_note()
    {
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $studentid = Student::save(['firstName'=>'student', 'lastName'=>' ', 'classId'=>$classid]);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);
        $this->browse(function ($browser) use ($studentid, $user, $classid){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/notes/write')
                ->select('idClass', $classid)
                ->select('idStudent', $studentid)
                ->select('subject','Math')
                ->type('frm[note]', 'This is a note')
                ->press('Submit')
                ->assertPathIs('/notes/list')
                ->logout();
        });
        $this->assertDatabaseHas('notes', [
            'idClass' => $classid,
            'idTeach' => $teacherid,
            'idStudent' => $studentid,
            'subject' => 'Math',
            'note' => 'This is a note'
        ]);
    }

    public function test_as_teacher_want_insert_assignments()
    {
        $today = now();
        $date=$today->day.'/'.$today->month.'/'.$today->year;
        $date1=($today->day+1).'/'.$today->month.'/'.$today->year;

        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);


        $this->browse(function ($browser) use ($user,$classid,$date,$date1){
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
                ->attach('attachment[]',public_path('robots.txt'))
                ->type('lecturedate',$date)
                ->type('deadline',$date1)
                ->press('Submit')
                ->assertPathIs('/assignment/list')
                ->logout();
        });

        $this->assertDatabaseHas('assignments', [
            'text' => 'some text'
        ]);
    }

    public function test_as_teacher_want_insert_assignments_with_multi_material()
    {
        $today = now();
        $date=$today->day.'/'.$today->month.'/'.$today->year;
        $date1=($today->day+1).'/'.$today->month.'/'.$today->year;

        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);


        $this->browse(function ($browser) use ($user,$classid,$date,$date1){
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
                ->attach('attachment[]',public_path('robots.txt'))
                ->attach('attachment[]',public_path('timetable.csv'))
                ->type('lecturedate',$date)
                ->type('deadline',$date1)
                ->press('Submit')
                ->assertPathIs('/assignment/list')
                ->logout();
        });

        $this->assertDatabaseHas('assignments', [
            'text' => 'some text'
        ]);
    }


    public function test_as_teacher_want_insert_assignments_wrong_deadline()
    {
        $today = now();
        $date=$today->day.'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID' => 2]);
        $classid = Classroom::save(['id' => '1A', 'capacity' => 25, 'description' => 'molto bella']);
        $teacherid = Teacher::save(['firstName' => $user->name, 'lastName' => ' ', 'userId' => $user->id, 'email' => $user->email]);
        Teacher::saveTeaching(['idTeach' => $teacherid, 'idClass' => $classid, 'subject' => 'Math']);


        $this->browse(function ($browser) use ($user, $classid, $date) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/assignment/add')
                ->select('idClass', $classid)
                ->select('subject', 'Math')
                ->type('frm[text]', 'some text')
                ->type('frm[topic]', 'some topic')
                ->attach('attachment[]',public_path('robots.txt'))
                ->type('lecturedate',$date)
                ->type('deadline',$date)
                ->press('Submit');
            $browser->acceptDialog()
                ->assertPathIsNot('/assignment/list')
                ->logout();
        });

    }

    public function test_as_teacher_want_insert_assignments_wrong_date()
    {
        $today = now();
        $date=($today->day+1).'/'.$today->month.'/'.$today->year;
        $user = factory(User::class)->create(['roleID'=>2]);
        $classid = Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        $teacherid = Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>$classid,'subject'=>'Math']);


        $this->browse(function ($browser) use ($user,$classid,$date){
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
                ->attach('attachment[]',public_path('robots.txt'))
                ->type('lecturedate',$date)
                ->type('deadline',$date)
                ->press('Submit');
            $browser->acceptDialog()
                ->assertPathIsNot('/assignment/list')
                ->logout();
        });

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
                ->assertPathIs('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day)
                ->logout();

        });

        $this->assertDatabaseHas('student_attendance', [
            'studentId' => $studentid,
            'status' => 'absent',
            'lectureDate' => $today->year.'-'.$today->month.'-'.$day
        ]);
    }

    public function test_as_teacher_want_report_attendance_present()
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
                ->check('frm1[status]')
                ->type('frm1[description]','Some description')
                ->press('Submit')
                ->assertPathIs('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day)
                ->logout();

        });

        $this->assertDatabaseHas('student_attendance', [
            'studentId' => $studentid,
            'status' => 'present',
            'presence_status' => 'full',
            'lectureDate' => $today->year.'-'.$today->month.'-'.$day
        ]);
    }

    public function test_as_teacher_want_report_attendance_late()
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
                ->check('frm1[status]')
                ->type('frm1[description]','Some description')
                ->select('frm1[presence_status]','late')
                ->press('Submit')
                ->assertPathIs('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day)
                ->logout();

        });

        $this->assertDatabaseHas('student_attendance', [
            'studentId' => $studentid,
            'status' => 'present',
            'presence_status' => 'late',
            'lectureDate' => $today->year.'-'.$today->month.'-'.$day
        ]);
    }

    public function test_as_teacher_want_report_attendance_early()
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
                ->check('frm1[status]')
                ->type('frm1[description]','Some description')
                ->select('frm1[presence_status]','early')
                ->press('Submit')
                ->assertPathIs('/student/attendance/1A/'.$today->year.'-'.$today->month.'-'.$day)
                ->logout();

        });

        $this->assertDatabaseHas('student_attendance', [
            'studentId' => $studentid,
            'status' => 'present',
            'presence_status' => 'early',
            'lectureDate' => $today->year.'-'.$today->month.'-'.$day
        ]);
    }

    public function test_as_teacher_want_check_timetable()
    {


        $user = factory(User::class)->create(['roleID'=>2]);
        Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        Teacher::saveTeaching(['idTeach'=>1,'idClass'=>'1A','subject'=>'Math']);

        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/timetable/list')
                ->select('frm[classId]','1A')
                ->press('Submit')
                ->assertSee('Time Table of class 1A')
                ->logout();
        });

    }

    public function test_as_teacher_want_provide_meeting_slots()
    {

        $user = factory(User::class)->create(['roleID'=>2]);
        Teacher::save(['firstName'=>$user->name, 'lastName'=>' ', 'userId' => $user->id, 'email'=>$user->email]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);
        Teacher::saveTeaching(['idTeach'=>1,'idClass'=>'1A','subject'=>'Math']);

        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
            $browser->visit('/meetings/add')
                ->click('@slot1')
                ->click('@slot2')
                ->press('Provide slots')
                ->logout();
        });

        $this->assertDatabaseHas('meetings', [
            'id' => 1,
            'idTimeslot' => 1,
            'idTeacher' => 1
        ]);
    }


}


