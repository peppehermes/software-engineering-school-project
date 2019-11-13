<?php

namespace App\Http\Controllers;

use App\Models\Student;
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

        if(\Auth::user()->roleId==3){


            $myParentID = \Auth::user()->id;

            $students = \DB::table('student')
                ->join('studForParent', 'student.id', '=', 'studForParent.idStudent')
                ->join('users', 'users.id', '=', 'studForParent.idParent')
                ->where('studForParent.idParent', $myParentID )
                ->select('student.*')
                ->get();


            return view('home',['students'=>$students]);

        }
        else{
            return view('home');
        }


    }

    public function admin()

    {

        return view('admin');

    }
}
