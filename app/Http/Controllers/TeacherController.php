<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use DB;
use App\Models\teacher;
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
        return view('teacher.add');
    }

    public function store(Request $request)
    {

        $teacher = new Teacher();

        $data = request('frm');

        if($data){
            //create user
            $userData['email'] = request('email');
            $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];
            $teacherRole = DB::table('role')->where(['name' => 'Teacher'])->first();
            $userData['roleId'] = $teacherRole->id;
            $password=$this->password_generate(8);
            $userData['password'] = Hash::make($password);
            $userId=DB::table('users')->insertGetId($userData);

            $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);
            $data['userId']=$userId;

            if ($request->file('photo')) {

                $cover = $request->file('photo');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['photo'] = $fileName;
            }
            $teacher->save($data);
        }






        //send email
        $to_name =  $userData['name'] ;
        $to_email = $userData['email'];
        $data = array('name'=>$to_name, 'password' => $password);
        \Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Teacher Password');
        $message->from('sahar.saadatmandii@gmail.com','Password');
        });


        return redirect('/teacher/list');

    }

    public function list()
    {

        $teachers = DB::table('teacher')->orderby('id','desc')->paginate(10);

        return view('teacher.list', ['teachers' => $teachers]);
    }

    public function edit($id)
    {
        $teacherInfo = teacher::retrieveById($id);
        $teacherEmail = DB::table('users')->where(['id' =>$teacherInfo->userId])->first();
        if ($teacherInfo->birthday) {


            $birthday = explode('-', $teacherInfo->birthday);

            $teacherInfo->year = $birthday[0];
            $teacherInfo->month = $birthday[1];
            $teacherInfo->day = $birthday[2];
        }
        $teacherInfo->email=$teacherEmail->email;


        return view('teacher.edit', ['teacherInfo' => $teacherInfo]);
    }

    public function update(Request $request, $id)
    {

        $teacher = new Teacher();

        $data = request('frm');

        $data['birthday'] = implode('-', [request('year'), request('month'), request('day')]);


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        $teacher->save($data, $id);

        return redirect('/teacher/list');

    }

    public function delete($id)
    {

        DB::table('teacher')->where('id', $id)->delete();


        return redirect('/teacher/list');

    }

    public function password_generate($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

}
