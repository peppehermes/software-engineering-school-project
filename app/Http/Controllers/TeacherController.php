<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Teachers;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\Student;
use App\Models\Topic;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\Note;
use App\Models\Mark;
use App\Models\Timeslot;
use App\Models\Meeting;
use App\User;
use DB;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function add()
    {
        $classes = Classroom::retrieve();
        return view('teacher.add', ['classes' => $classes]);
    }

    public function store(Request $request)
    {


        $data = request('frm');
        $dataT = request('frmT');

        if ($data) {
            //create user
            $userData['email'] = strtolower(request('email'));
            $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];
            $userData['roleId'] = Role::retrieveByRole('Teacher');

            $password = $this->password_generate(8);
            $userData['password'] = Hash::make($password);
            $userId = User::saveUser($userData);

            if ($data['birthday']) {
                $data['birthday'] = Student::convertDate($data['birthday']);
            }


            $data['userId'] = $userId;

            if ($request->file('photo')) {

                $cover = $request->file('photo');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['photo'] = $fileName;
            }

            $Teachid = Teacher::save($data);
            $dataT['idTeach'] = $Teachid;
            Teacher::saveTeaching($dataT);
        }


        //send email
        $to_name = $userData['name'];
        $to_email = $userData['email'];
        $data = array('name' => $to_name, 'password' => $password);
        \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Teacher Password');
            $message->from('sahar.saadatmandii@gmail.com', 'Password');
        });


        return redirect('/teacher/list')->with(['message' => 'Successfull operation!']);

    }

    public function list()
    {

        $teachers = Teacher::retrievePagination(10);

        return view('teacher.list', ['teachers' => $teachers]);
    }

    public function edit($id)
    {

        $teacherInfo = Teacher::retrieveById($id);
        $teacherEmail = User::retrieveById($teacherInfo->userId);
        if ($teacherInfo->birthday) {
            $teacherInfo->birthday = Student::convertDateView($teacherInfo->birthday);
        }


        $teacherInfo->email = $teacherEmail->email;


        return view('teacher.edit', ['teacherInfo' => $teacherInfo]);
    }

    public function update(Request $request, $id)
    {

        $teacher = Teacher::retrieveById($id);

        $data = request('frm');

        if ($data['birthday']) {
            $data['birthday'] = Student::convertDate($data['birthday']);
        }
        $userData['email'] = strtolower(request('email'));
        $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];


        User::saveUser($userData, $teacher->userId);


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        Teacher::save($data, $id);

        return redirect('/teacher/list')->with(['message' => 'Successfull operation!']);

    }

    public function delete($id)
    {

        $teacherInfo = Teacher::retrieveById($id);
        Teacher::delete($id);
        User::deleteById($teacherInfo->userId);


        return redirect('/teacher/list')->with(['message' => 'Successfull operation!']);

    }

    public function password_generate($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    public function listtopic()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $topics = Topic::retrieveTeachersPagination($teachId);
        return view('topic.list', ['topics' => $topics]);
    }

    public function storetopic(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Topic::save($data);
        }
        return redirect('/topic/list')->with(['message' => 'Successfull operation!']);
    }

    public function addtopic()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('topic.add', ['classes' => $classes, 'subjects' => $subjects, 'date' => $dateview]);
    }

    public function storeassignment(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            $data['deadline'] = request('deadline');
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['deadline'] = Student::convertDate($data['deadline']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            if ($request->file('attachment')) {

                $cover = $request->file('attachment');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['attachment'] = $fileName;
            }
            Assignment::save($data);
        }
        return redirect('/assignment/list')->with(['message' => 'Successfull operation!']);


    }


    public function addassignment()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('assignments.add', ['classes' => $classes, 'subjects' => $subjects, 'date' => $dateview]);
    }


    public function listassignment()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $assignments = Assignment::retrieveTeachersPagination($teachId);
        return view('assignments.list', ['assignments' => $assignments]);
    }

    public function storemark(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['mark'] = request('mark');
            $data['idStudent'] = request('idStudent');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Mark::save($data);
        }
        return redirect('/mark/list')->with(['message' => 'Successfull operation!']);


    }


    public function addmark()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.add', ['classes' => $classes, 'studId' => $studId, 'subjects' => $subjects, 'date' => $dateview]);
    }


    public function listmark()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $marks = Mark::retrieveTeachersPagination($teachId);
        return view('marks.list', ['marks' => $marks]);
    }


    public function addmaterial()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        return view('suppmaterial.add', ['classes' => $classes, 'subjects' => $subjects]);
    }

    public function storematerial(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create topic
            $data['date'] = date("Y-m-d");
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');

            if ($request->file('material')) {

                $cover = $request->file('material');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['material'] = $fileName;
            }

            Material::save($data);
        }
        return redirect('/material/list')->with(['message' => 'Successfull operation!']);
    }

    public function listmaterial()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $materials = Material::retrieveTeachersPagination($teachId);
        return view('suppmaterial.list', ['materials' => $materials]);
    }

    public function writenote()
    {
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('notes.write', ['classes' => $classes, 'stud' => $studId, 'subjects' => $subjects]);
    }

    public function storenote(Request $request)
    {
        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create note
            $data['date'] = date("Y-m-d");
            $data['idClass'] = request('idClass');
            $data['idStudent'] = request('idStudent');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');

            Note::save($data);
        }
        return redirect('/notes/list')->with(['message' => 'Successfull operation!']);
    }

    public function listnotes()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $notes = Note::retrieveTeachersPagination($teachId);

        return view('notes.list', ['notes' => $notes]);
    }


    public function listtimeslot(Request $request)
    {
        $form = request('frm');
        $week = $form['week'];
        $year_week=explode('-',$week);
        $date1 = date( "l, M jS, Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'1') ); // First day of week
        $date2 = date( "l, M jS, Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'7') ); // Last day of week

        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $exist=Meeting::retrieveMeetingperTeacher($teachId);
        $teach = Teacher::retrieveById($teachId);
        if (count($exist) == 0)

            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . ' ' . $teach->lastName . ' first provide the two timeslots.']);

        else {
            $times = Timeslot::retrieve();
            $bool = 1;
            $provided = Meeting::retrieveWeeklyMeetingperTeacher($teachId, $week);// already provided timeslots
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);

            if (count($timeslots) > 0) {


                return view('meetings.list', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool, 'provided' => $provided, 'week' => $week, 'date1' => $date1, 'date2' => $date2]);

            } else
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);

        }
    }

    public function addtimeslot()
    {

        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $times = Timeslot::retrieve();
        $bool = 1;
        $teach = Teacher::retrieveById($teachId);
        $provided = Meeting::retrieveMeetingperTeacher($teachId);

        if (count($provided) > 0)
            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName .' '. $teach->lastName . ' has already provided the two timeslots']);

        else {
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);
            if (count($timeslots) > 0) {


                return view('meetings.add', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool,]);

            } else
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);

        }
    }

    public function addweek()
    {
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $teach = Teacher::retrieveById($teachId);
        return view('meetings.addweek', ['teach' => $teach]);
    }


    public function storetimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week=(stripslashes($_POST['week']));
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $provided = Meeting::retrieveWeeklyMeetingperTeacher($teachId,$week);

        if ((count($provided)+count($slots)) > 3) {

            $message = 'Too many timeslots provided, please provide at most 3!';
            return $message;
        }

        else {
            $data['idTeacher'] = $teachId;
            $data['idweek'] = $week;

            foreach ($slots as $d) {
                $data['idTimeslot'] = $d;
                Meeting::save($data);
            }
            return 0;
        }

    }

    public function storealltimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week=(stripslashes($_POST['week']));
        $year = date("Y");
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $data['idTeacher'] = $teachId;
        // if we are after September
        if($week>=37) {
            // between september and the end of the year
            for ($i = $week; $i < 52; $i++) {
                $data['idweek'] = ($year . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
           // between january and end of the school in june
            for ($i = 2; $i < 29; $i++) {
                if($i<10)
                    $data['idweek'] = $year+1 . '-W' .'0'. $i;
                else
                    $data['idweek'] = ($year+1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
        }
       // if we are after January
        else if($week>1 && $week<28){
            for ($i = $week; $i < 29; $i++) {
                if($i<10)
                    $data['idweek'] = $year+1 . '-W' .'0'. $i;
                else
                    $data['idweek'] = ($year+1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
        }
        // we are in the first week of january
        else if($week==1) {
            for ($i = $week+1; $i < 29; $i++) {
                if($i<10)
                    $data['idweek'] = $year+1 . '-W' .'0'. $i;
                else
                    $data['idweek'] = ($year+1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
        }
        // between june and september,it's not possible to provide
        else
            return 1;
    }

    public function freetimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week=(stripslashes($_POST['week']));
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);


        foreach ($slots as $d) {

                Meeting::delete_per_teacher($d,$teachId,$week);
            }

        }



}
