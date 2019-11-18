<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class ClassroomController extends Controller
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

        return view('classroom.add');
    }

    public function store()
    {

        $classroom = new Classroom();

        $data = request('frm');


        $classroomInfo = Classroom::retrieveClass($data['id']);


        if (!isset($classroomInfo)) {
            $classroom->save($data);
        } else {
            return \Redirect::back()->withErrors([$data['id'] . ' class is already defined.']);
        }


        return redirect('/classroom/list');

    }

    public function list()
    {

        $classrooms = Classroom::retrieveAll();

        return view('classroom.list', ['classrooms' => $classrooms]);
    }

    public function edit($id)
    {
        $classroomInfo = Classroom::retrieveClass($id);


        return view('classroom.edit', ['classroomInfo' => $classroomInfo]);
    }

    public function update($id)
    {

        $classroom = new Classroom();

        $data = request('frm');

        $classroomInfo = Classroom::retrieveClass($data['id']);


        if (isset($classroomInfo) && $data['id'] == $id) {
            $classroom->save($data, $id);
        } elseif (!isset($classroomInfo)) {
            $classroom->save($data, $id);
        } else {
            return \Redirect::back()->withErrors([$data['id'] . ' class is already defined.']);
        }


        return redirect('/classroom/list');

    }

    public function delete($id)
    {

        Classroom::delete($id);


        return redirect('/classroom/list');

    }

    public function composition($id)
    {
        $studentsList = Student::retrieveStudentClass($id);

        $count = Count($studentsList);

        $classroom = Classroom::retrieveById($id);

        if ($count == $classroom->capacity) {
            $full = 1;
        } else {
            $full = 0;
        }

        $students = Student::retrieveStudentWithoutClass();

        return view('classroom.composition', ['students' => $students, 'classroom' => $classroom, 'studentsList' => $studentsList, 'full' => $full]);
    }

    public function classComposition(Request $request, $id)
    {
        $students = $request->input('frm');

        if(isset($students)){
            foreach ($students as $studentId) {
                Student::save(['classId' => $id], $studentId);
            }
        }
        else{
            return redirect('/classroom/composition/'.$id)->withErrors("No student selected!");
        }



        return redirect('/classroom/list');
    }

    public function deleteStudent($id)
    {

        Student::save(['classId' => ''], $id);

        return redirect('/classroom/list');
    }


}
