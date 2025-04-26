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

class CommunicationsController extends Controller
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


    public function add()
    {
        return view('communications.add');
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


        return redirect('/communications/list')->with(['message' => 'Successfull operation!']);

    }


    public function list()
    {

        $communications = Communications::retrieveUserAndComm();

        if (\Auth::user()->roleId == User::roleParent) {

            $myParentID = \Auth::user()->id;

            $students = Student::retrieveStudentsForParent($myParentID);


            return view('communications.list', ['communications' => $communications, 'students' => $students]);


        } else
            return view('communications.list', ['communications' => $communications]);
    }


}
