<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
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

        if (\Auth::user()->roleId == 3) {


            $myParentID = \Auth::user()->id;

            $students = Student::retrieveStudentsForParent($myParentID);


            return view('home2', ['students' => $students]);

        } elseif (\Auth::user()->roleId == 2) {


            $userId = \Auth::user()->id;
            $teacherId = Teacher::retrieveId($userId);

            $classRooms = Teacher::retrieveTeacherClass($teacherId);



            return view('home2', ['classRooms' => $classRooms, 'today' => date('Y-m-d')]);


        } else {
            return view('home2');
        }


    }

    public function admin()

    {

        return view('admin');

    }
}
