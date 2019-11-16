<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Role;
use App\User;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
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
        $classrooms = Classroom::retrieve();
        return view('student.add', ['classrooms' => $classrooms]);
    }

    public function store(Request $request)
    {

        $student = new Student();

        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);

        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));

            $data['photo'] = $fileName;
        }
        $id = $student->save($data);

        return redirect('/student/edit/' . $id)->with(['parent' => 1]);

    }

    public function list()
    {

        $students = DB::table('student')->orderby('id', 'desc')->paginate(10);

        return view('student.list', ['students' => $students]);
    }

    public function edit($id)
    {
        $studentInfo = Student::retrieveById($id);
        if ($studentInfo->birthday) {


            $birthday = explode('-', $studentInfo->birthday);

            $studentInfo->year = $birthday[0];
            $studentInfo->month = $birthday[1];
            $studentInfo->day = $birthday[2];
        }


        $classrooms = Classroom::retrieve();

        return view('student.edit', ['studentInfo' => $studentInfo, 'classrooms' => $classrooms]);
    }

    public function update(Request $request, $id)
    {

        $student = new Student();

        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);

        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        $student->save($data, $id);

        return redirect('/student/list');

    }

    public function delete($id)
    {

        DB::table('student')->where('id', $id)->delete();


        return redirect('/student/list');

    }

    public function showmarks($id)
    {
        if (\Auth::user()->roleId == 3) {


            $myParentID = \Auth::user()->id;

            $students = \DB::table('student')
                ->select('student.*')
                ->join('studForParent', 'student.id', '=', 'studForParent.idStudent')
                ->join('users', 'users.id', '=', 'studForParent.idParent')
                ->where('studForParent.idParent', $myParentID)
                ->get();


            $marks = \DB::table('marks')
                ->select('marks.*', 'teacher.firstName as teachFirstName', 'teacher.lastName as teachLastName')
                ->join('teacher', 'teacher.id', '=', 'marks.idTeach')
                ->where('marks.idStudent', $id)
                ->get();


            return view('student.showmarks', ['students' => $students, 'marks' => $marks]);

        } else {
            return view('student.showmarks');
        }


    }

    public function listforparents($idStud)
    {
        $usId = \Auth::user()->id;


        $idClass = DB::table('student')
            ->where('id', $idStud)
            ->value('classId');

        $topics = DB::table('lecturetopic')
            ->join('teacher', 'lecturetopic.idTeach', '=', 'teacher.id')
            ->where('idClass', $idClass)
            ->select('lecturetopic.*', 'teacher.firstName as firstName', 'teacher.lastName as lastName')
            ->get();


        $students = DB::table('student')
            ->join('studForParent', 'student.id', '=', 'studForParent.idStudent')
            ->where('studForParent.idParent', $usId)
            ->select('student.*')
            ->get();

        return view('student.topiclist', ['topics' => $topics], ['students' => $students]);
    }

    public function storeParent(Request $request, $id)
    {

        $roleClass = new Role();
        $studentClass = new Student();
        $userClass = new User();
        $userData['roleId'] = $roleClass->retrieveByRole('Parent');
        $parentName1 = $request->input('parentName1');
        $parentEmail1 = $request->input('parentEmail1');
        $parentName2 = $request->input('parentName2');
        $parentEmail2 = $request->input('parentEmail2');

        if ($parentName1 != '' && $parentEmail1 != '') {

            $data['mailParent1'] = $parentEmail1;

            $userData['name'] = $parentName1;
            $password = $userClass::password_generate(8);
            $userData['password'] = Hash::make($password);
            $userData['email'] = $parentEmail1;

            DB::table('users')->insertGetId($userData);

            $studentClass->save($data, $id);

            //send email
            $to_name = $userData['name'];
            $to_email = $userData['email'];
            $data = array('name' => $to_name, 'password' => $password);
            \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Parent Password');
                $message->from('sahar.saadatmandii@gmail.com', 'Password');
            });


        }

        if ($parentName2 != '' && $parentEmail2 != '') {

            $data['mailParent2'] = $parentEmail2;

            $userData['name'] = $parentName2;
            $password = $userClass::password_generate(8);
            $userData['password'] = Hash::make($password);
            $userData['email'] = $parentEmail2;
            DB::table('users')->insertGetId($userData);
            $studentClass->save($data, $id);

            //send email
            $to_name = $userData['name'];
            $to_email = $userData['email'];
            $data = array('name' => $to_name, 'password' => $password);
            \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Parent Password');
                $message->from('sahar.saadatmandii@gmail.com', 'Password');
            });
        }

        return redirect('/student/list');


    }

}
