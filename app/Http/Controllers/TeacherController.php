<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Teachers;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\Topic;
use App\Models\Assignment;
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
        return view('teacher.add',['classes' => $classes]);
    }

    public function store(Request $request)
    {


        $data = request('frm');
        $dataT = request('frmT');

        if ($data) {
            //create user
            $userData['email'] = request('email');
            $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];
            $userData['roleId'] = Role::retrieveByRole('Teacher');

            $password = $this->password_generate(8);
            $userData['password'] = Hash::make($password);
            $userId = DB::table('users')->insertGetId($userData);

            $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);
            $data['userId'] = $userId;

            if ($request->file('photo')) {

                $cover = $request->file('photo');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['photo'] = $fileName;
            }

            $Teachid = Teacher::save($data);
            $dataT['idTeach']=$Teachid;
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


        return redirect('/teacher/list');

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


            $birthday = explode('-', $teacherInfo->birthday);

            $teacherInfo->year = $birthday[0];
            $teacherInfo->month = $birthday[1];
            $teacherInfo->day = $birthday[2];
        }
        $teacherInfo->email = $teacherEmail->email;


        return view('teacher.edit', ['teacherInfo' => $teacherInfo]);
    }

    public function update(Request $request, $id)
    {


        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        Teacher::save($data, $id);

        return redirect('/teacher/list');

    }

    public function delete($id)
    {

        $teacherInfo = Teacher::retrieveById($id);
        Teacher::delete($id);
        User::deleteById($teacherInfo->userId);


        return redirect('/teacher/list');

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
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Topic::save($data);
        }
        return redirect('/topic/list');
    }

    public function addtopic()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrieveTeaching($teachId);
        return view('topic.add', ['classes' => $classes]);
    }

    public function storeassignment (Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = implode('-', [request('year'), request('month'), request('day')]);
            $data['deadline'] = implode('-', [request('yeard'), request('monthd'), request('dayd')]);
            $data['idClass'] = request('idClass');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Assignment::save($data);
        }
        return redirect('/assignment/list');


    }


    public function addassignment()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrieveTeaching($teachId);
        return view('assignments.add', ['classes' => $classes]);
    }


    public function listassignment()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $assignments = Assignment::retrieveTeachersPagination($teachId);
        return view('assignments.list', ['assignments' => $assignments]);
    }


}
