<?php

namespace App\Http\Controllers;

use App\Models\ClassCoordinator;
use App\Models\Classroom;
use App\Models\Teacher;
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


        return redirect('/classroom/list')->with(['message' => 'Successfull operation!']);

    }

    public function list()
    {

        $classrooms = Classroom::retrieveAll();

        return view('classroom.list', ['classrooms' => $classrooms]);
    }

    public function edit($id)
    {
        $classroomInfo = Classroom::retrieveClass($id);
        $coordinatorId = ClassCoordinator::retrieveByClassId($id);

        // If the class has a coordinator then it is returned
        if (isset($coordinatorId))
            $coordinator = Teacher::retrieveById($coordinatorId);
        else
            // Otherwise the string "Select Coordinator" is displayed
            $coordinator = 'Select Coordinator';

        $teachersNotCoordinator = ClassCoordinator::retrieveNonCoordinatorTeachers($id);

        return view('classroom.edit', ['classroomInfo' => $classroomInfo,
            'teachers' => $teachersNotCoordinator, 'coordinator' => $coordinator]);
    }

    public function update($id)
        //Add the class coordinator part
    {
        $classroom = new Classroom();

        $data = request('frm');

        $coordinatorId = request('class_coordinator_id');

        $classroomInfo = Classroom::retrieveClass($data['id']);

        $coordinatorInfo = ['idTeach' => $coordinatorId,
            'idClass' => $data['id']];

        if (isset($classroomInfo) && $data['id'] == $id) {
            $classroom->save($data, $id);
            if ($coordinatorId != 0) {
                $idTeach = ClassCoordinator::retrieveByClassId($id);
                if (isset($idTeach))
                    ClassCoordinator::save($coordinatorInfo, $idTeach);
                else
                    ClassCoordinator::save($coordinatorInfo);
            }
        } elseif (!isset($classroomInfo)) {
            $classroom->save($data, $id);
            if ($coordinatorId != 0) {
                $idTeach = ClassCoordinator::retrieveByClassId($id);
                if (isset($idTeach))
                    ClassCoordinator::save($coordinatorInfo, $idTeach);
                else
                    ClassCoordinator::save($coordinatorInfo);
            }
        } else {
            return \Redirect::back()->withErrors([$data['id'] . ' class is already defined.']);
        }

        return redirect('/classroom/list')->with(['message' => 'Successfull operation!']);
    }

    public function delete($id)
    {

        Classroom::delete($id);


        return redirect('/classroom/list')->with(['message' => 'Successfull operation!']);

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

        if (isset($students)) {
            foreach ($students as $studentId) {
                Student::save(['classId' => $id], $studentId);
            }
        } else {
            return redirect('/classroom/composition/' . $id)->withErrors("No student selected!");
        }


        return redirect('/classroom/list')->with(['message' => 'Successfull operation!']);
    }

    public function deleteStudent($id)
    {

        Student::save(['classId' => ''], $id);

        return redirect('/classroom/list')->with(['message' => 'Successfull operation!']);
    }


}
