<?php

namespace Tests\Browser;

use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Timetable;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OfficerTest extends DuskTestCase
{

    use DatabaseMigrations;

    //this method will create an officer administrator and log in with credentials
    public function login_officer(){

        $user = factory(User::class)->create(['roleId'=>1]);
        Classroom::save(['id'=>'1A','capacity'=>25,'description'=>'molto bella']);

        $this->browse(function ($browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }

    public function initialize_timetable(){

        $teacher = factory(User::class)->create(['roleID'=>2]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>'C','phone' =>'1','birthPlace'=>'London', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Italian']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'English']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Physics']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Gym']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Religion']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'History']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Science']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Art']);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Latin']);
    }

    public function test_as_officer_want_enroll_students()
    {

        $this->login_officer();

        $this->browse(function ($browser) {
            $browser->visit('/student/add')
                ->type('frm[firstName]', 'Giorgio')
                ->type('frm[lastName]', 'Santangelo')
                ->type('frm[birthPlace]', 'Catania')
                ->type('frm[birthday]', '10/02/2005')
                ->type('frm[address]', 'null')
                ->type('frm[phone]', '1234567890')
                ->type('frm[postCode]', '12345')
                ->type('frm[fiscalCode]', 'SNTGRG05B10C351D')
                ->type('frm[email]', 'test@test.com')
                ->select('frm[gender]','M')
                ->select('frm[classId]','1A')
                ->select('frm[firstYear]','Yes')
                ->type('frm[description]', 'null')
                ->select('frm[skill]', '8')
                ->press('Submit')
                ->type('parentName1','Gastani Frinzi')
                ->type('parentEmail1','gastani@test.com')
                ->press('Submit')
                ->assertPathIs('/student/list')
                ->logout();
        });
        $this->assertDatabaseHas('student', [
            'firstName' => 'Giorgio',
            'lastName' => 'Santangelo'
        ]);
    }

    public function test_as_officer_want_import_timetable()
    {
        $this->login_officer();


        $this->browse(function ($browser) {
            $browser->visit('/timetable/add')
                ->select('frm[classId]','1A')
                ->attach('timetable',public_path('timetable.csv'))
                ->press('Submit')
                ->assertPathIs('/timetable/list')
                ->logout();
        });
        $this->assertDatabaseHas('timetable', [
            'idClass' => '1A'
        ]);
    }

    public function test_as_officer_want_add_communications()
    {
        $this->login_officer();


        $this->browse(function ($browser) {
            $browser->visit('/communications/add')
                ->type('frm[description]','Some communication')
                ->press('Submit')
                ->assertPathIs('/communications/list')
                ->logout();
        });
        $this->assertDatabaseHas('communications', [
            'description' => 'Some communication'
        ]);
    }

    public function test_as_officer_want_compose_classrooms()
        {

            Student::save(['firstName'=>'Giorgio', 'lastName'=>'Santangelo', 'mailParent1'=>'parent@test.com']);

            $this->login_officer();

            $this->browse(function ($browser) {
                $browser->visit('/classroom/composition/1A')
                    ->click('@student1')
                    ->press('Submit')
                    ->assertPathIs('/classroom/list')
                    ->logout();
            });

            $this->assertDatabaseHas('student', [
                'firstName' => 'Giorgio',
                'lastName' => 'Santangelo',
                'classId' =>   '1A'
            ]);


    }

    public function test_as_officer_want_edit_teacher_data()
    {

        $teacher = factory(User::class)->create(['roleID'=>2]);
        $teacherid = Teacher::save(['firstName'=>$teacher->name, 'lastName'=>'null','phone' =>'1234567890','birthPlace'=>'London', 'userId' => $teacher->id, 'email'=>$teacher->email]);
        Teacher::saveTeaching(['idTeach'=>$teacherid,'idClass'=>'1A','subject'=>'Math']);

        $this->login_officer();


        $this->browse(function ($browser) {
            $browser->visit('/teacher/edit/1')
                ->type('frm[birthPlace]','Turin')
                ->press('Submit')
                ->logout();
        });

        $this->assertDatabaseHas('teacher', [
            'firstName' => $teacher->name,
            'lastName' => 'null',
            'birthPlace' => 'Turin'
        ]);


    }

    public function test_as_officer_want_build_timetable()
    {

        $this->initialize_timetable();

        $this->login_officer();

        $this->browse(function ($browser) {
            $browser->visit('/timetable/chooseclass')
                ->select('frm[classId]','1A')
                ->press('Submit')
                ->assertPathIs('/timetable/addmanual')
                ->select('frm1','italian')
                ->select('frm2','italian')
                ->select('frm3','italian')
                ->select('frm4','italian')
                ->select('frm5','Science')
                ->select('frm6','Science')
                ->select('frm7','Art')
                ->select('frm8','Art')
                ->select('frm9','Art')
                ->select('frm10','Art')
                ->select('frm11','Latin')
                ->select('frm12','Latin')
                ->select('frm13','Latin')
                ->select('frm14','English')
                ->select('frm15','English')
                ->select('frm16','English')
                ->select('frm17','English')
                ->select('frm18','Physics')
                ->select('frm19','Physics')
                ->select('frm20','Physics')
                ->select('frm21','Physics')
                ->select('frm22','Gym')
                ->select('frm23','Gym')
                ->select('frm24','Gym')
                ->select('frm25','Religion')
                ->select('frm26','Religion')
                ->select('frm27','Religion')
                ->select('frm28','History')
                ->select('frm29','History')
                ->select('frm30','History')
                ->press('Submit');
            $browser->acceptDialog()
                ->logout();
        });
        $this->assertDatabaseHas('timetable', [
            'idClass' => '1A'
        ]);
    }

    public function test_as_officer_want_build_timetable_hour_constraint_violation()
    {
        $this->initialize_timetable();

        $this->login_officer();


        $this->browse(function ($browser) {
            $browser->visit('/timetable/chooseclass')
                ->select('frm[classId]','1A')
                ->press('Submit')
                ->assertPathIs('/timetable/addmanual')
                ->select('frm1','italian')
                ->select('frm2','italian')
                ->select('frm3','italian')
                ->select('frm4','italian')
                ->select('frm5','italian')
                ->select('frm6','italian')   //here we are putting 6 hours of "italian" sujbect, this will generate a constraint alarm, cause in the database we have set 5 hours of "italian"
                ->select('frm7','Art')
                ->select('frm8','Art')
                ->select('frm9','Art')
                ->select('frm10','Art')
                ->select('frm11','Latin')
                ->select('frm12','Latin')
                ->select('frm13','Latin')
                ->select('frm14','English')
                ->select('frm15','English')
                ->select('frm16','English')
                ->select('frm17','English')
                ->select('frm18','Physics')
                ->select('frm19','Physics')
                ->select('frm20','Physics')
                ->select('frm21','Physics')
                ->select('frm22','Gym')
                ->select('frm23','Gym')
                ->select('frm24','Gym')
                ->select('frm25','Religion')
                ->select('frm26','Religion')
                ->select('frm27','Religion')
                ->select('frm28','History')
                ->select('frm29','History')
                ->select('frm30','History')
                ->press('Submit');
            $browser->acceptDialog()
                ->assertSee('There was a constraint violation (HOUR ASSIGNMENT NOT COHERENT), check properly the timetables')
                ->logout();
        });
        $this->assertDatabaseHas('timetable', [
            'idClass' => '1A'
        ]);
    }

    public function test_as_officer_want_build_timetable_teacher_constraint_violation()
    {
        $this->initialize_timetable();

        //let's add a tuple into the timetable in order to force the violation of teaching
        Timetable::save(['idClass'=>'1B','idTimeslot'=>1,'idTeacher'=>1 ,'subject'=>'History']);

        $this->login_officer();


        $this->browse(function ($browser) {
            $browser->visit('/timetable/chooseclass')
                ->select('frm[classId]','1A')
                ->press('Submit')
                ->assertPathIs('/timetable/addmanual')
                ->select('frm1','italian')  //this set will generate the violation alarm, the professor is actually teaching in two classes at the same time
                ->select('frm2','italian')
                ->select('frm3','italian')
                ->select('frm4','italian')
                ->select('frm5','italian')
                ->select('frm6','italian')
                ->select('frm7','Art')
                ->select('frm8','Art')
                ->select('frm9','Art')
                ->select('frm10','Art')
                ->select('frm11','Latin')
                ->select('frm12','Latin')
                ->select('frm13','Latin')
                ->select('frm14','English')
                ->select('frm15','English')
                ->select('frm16','English')
                ->select('frm17','English')
                ->select('frm18','Physics')
                ->select('frm19','Physics')
                ->select('frm20','Physics')
                ->select('frm21','Physics')
                ->select('frm22','Gym')
                ->select('frm23','Gym')
                ->select('frm24','Gym')
                ->select('frm25','Religion')
                ->select('frm26','Religion')
                ->select('frm27','Religion')
                ->select('frm28','History')
                ->select('frm29','History')
                ->select('frm30','History')
                ->press('Submit');
            $browser->acceptDialog()
                ->assertSee('There was a constraint violation (TEACHER IN MULTIPLE CLASSES), check properly the timetables')
                ->logout();
        });
        $this->assertDatabaseHas('timetable', [
            'idClass' => '1A'
        ]);
    }



}
