<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;

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
        $student->save($data);

        return redirect('/student/list');

    }

    public function list()
    {

        $students = DB::table('student')->orderby('id','desc')->paginate(10);

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

    public function delete( $id)
    {

        DB::table('student')->where('id', $id)->delete();


        return redirect('/student/list');

    }

}
