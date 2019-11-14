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

        $students = DB::table('student')->orderby('id','desc')->paginate(2);

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

    public function showmarks($id)
    {
        if(\Auth::user()->roleId==3){


            $myParentID = \Auth::user()->id;

            $students = \DB::table('student')
                ->join('studForParent', 'student.id', '=', 'studForParent.idStudent')
                ->join('users', 'users.id', '=', 'studForParent.idParent')
                ->where('studForParent.idParent', $myParentID )
                ->select('student.*')
                ->get();

            $marks = \DB::table('marks')
                ->join('teacher', 'teacher.id', '=', 'marks.idTeach')
                ->where('marks.idStudent', $id )
                ->select('marks.*', 'teacher.firstName as teachFirstName', 'teacher.lastName as teachLastName')
                ->get();

            return view('student.showmarks',['students'=>$students, 'marks'=>$marks]);

        }
        else{
            return view('student.showmarks');
        }


    }

    public function listforparents()
    {
        $usId = \Auth::user()->id;

        $idStud = DB::table('studforparent')
            ->where('idParent',$usId)
            ->value('idStudent');

        $idClass = DB::table('student')
            ->where('id',$idStud)
            ->value('classId');

        $topics = DB::table('lecturetopic')
            ->where('idClass',$idClass)
            ->select('lecturetopic.*')
            ->get();

        return view('student.topiclist', ['topics' => $topics]);
    }


}
