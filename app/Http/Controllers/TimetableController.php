<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Communications;
use App\User;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class TimetableController extends Controller
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

    public function import()
    {
        Excel::import(new UsersImport, 'users.xlsx');

        return redirect('/')->with('success', 'All good!');
    }


    public function add()
    {

        $classrooms = Classroom::retrieve();
        return view('timetable.add', ['classrooms' => $classrooms]);
    }

    public function store()
    {

        $communication = new Communications();

        $data = request('frm');

        if ($data) {
            //create communication
            $data['idAdmin'] = \Auth::user()->id;
            $communication->addNewComm($data);
        }





        return redirect('/communications/list');

    }




    public function list()
    {


            return view('timetable.list');
    }





}
