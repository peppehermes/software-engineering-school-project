<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Role;
use App\Models\Topic;
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


        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);

        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));

            $data['photo'] = $fileName;
        }
        $id = Student::save($data);

        return redirect('/student/edit/' . $id)->with(['parent' => 1]);

    }

    public function list()
    {


        $students = Student::retrievePagination(10);

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


        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);

        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        Student::save($data, $id);

        return redirect('/student/list');

    }

    public function delete($id)
    {

        Student::delete($id);
        return redirect('/student/list');

    }

    public function showmarks($id)
    {
        if (\Auth::user()->roleId == 3) {

            $myParentID = \Auth::user()->id;

            $students = Student::retrieveStudentsForParent($myParentID);

            foreach ($students as $student){
                $stIds[]=$student->id;
            }
            if(!in_array($id,$stIds)){
                return \Redirect('/')->withErrors([' You dont have permission for another student!']);
            }

            $marks = Student::retrieveMarksForStudent($id);




            return view('student.showmarks', ['students' => $students, 'marks' => $marks]);

        } else {
            return view('student.showmarks');
        }


    }

    public function listforparents($idStud)
    {
        $usId = \Auth::user()->id;


        $idClass = Student::retrieveClassId($idStud);

        $topics = Topic::getTopicByClass($idClass);

        $students = Student::retrieveStudentsForParent($usId);

        foreach ($students as $student){
            $stIds[]=$student->id;
        }
        if(!in_array($idStud,$stIds)){
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        return view('student.topiclist', ['topics' => $topics, 'students' => $students]);
    }

    public function storeParent(Request $request, $id)
    {


        $userData['roleId'] = Role::retrieveByRole('Parent');
        $parentName1 = $request->input('parentName1');
        $parentEmail1 = $request->input('parentEmail1');
        $parentName2 = $request->input('parentName2');
        $parentEmail2 = $request->input('parentEmail2');

        if ($parentName1 != '' && $parentEmail1 != '') {

            $data['mailParent1'] = $parentEmail1;

            $userData['name'] = $parentName1;
            $password = User::password_generate(8);
            $userData['password'] = Hash::make($password);
            $userData['email'] = $parentEmail1;

            User::saveUser($userData);

            Student::save($data, $id);

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
            $password = User::password_generate(8);
            $userData['password'] = Hash::make($password);
            $userData['email'] = $parentEmail2;
            User::saveUser($userData);
            Student::save($data, $id);

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
