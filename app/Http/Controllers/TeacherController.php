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
            $data['date'] = implode('-', [request('year'), request('month'), request('day')]);
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

        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('topic.add', ['classes' => $classes,'subjects' => $subjects]);
    }

    public function storeassignment(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = implode('-', [request('year'), request('month'), request('day')]);
            $data['deadline'] = implode('-', [request('yeard'), request('monthd'), request('dayd')]);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Assignment::save($data);
        }
        return redirect('/assignment/list')->with(['message' => 'Successfull operation!']);


    }


    public function addassignment()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('assignments.add', ['classes' => $classes,'subjects' => $subjects]);
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
            $data['date'] = implode('-', [request('year'), request('month'), request('day')]);
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

        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.add', ['classes' => $classes, 'studId' => $studId,'subjects' => $subjects]);
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
        return view('suppmaterial.add', ['classes' => $classes,'subjects' => $subjects]);
    }

    public function storematerial(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create topic
            $data['date'] = date("Y-n-d");
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
        $i = 0;
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('notes.write', ['classes' => $classes, 'stud' => $studId,'subjects' => $subjects]);
    }

    public function storenote(Request $request)
    {
        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create note
            $data['date'] = date("Y-n-d");
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
}
