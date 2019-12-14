<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Communications;
use App\Models\Teacher;
use App\Models\Timeslot;
use App\Models\Timetable;
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

//    public function import()
//    {
//        Excel::import(new UsersImport, 'users.xlsx');
//
//        return redirect('/')->with('success', 'All good!');
//    }


    public function add()
    {

        $classrooms = Classroom::retrieve();
        return view('timetable.add', ['classrooms' => $classrooms]);
    }

    public function store(Request $request)
    {
        $save = false;
        $data = request('frm');
        $timetable['idClass'] = $data['classId'];

        $file = $request->file('timetable');


        //Check the file encoding and BOM.

        $content = file_get_contents($file->path());

        $content = $this->remove_utf8_bom($content);
        file_put_contents($file->path(), $content);


        //get header
        if (($handle = fopen($file->path(), "r")) !== FALSE) {

            $sep = ",";

            $csvHeaders = fgetcsv($handle, 1000, $sep);

        }

        //get body
        while (($row = fgetcsv($handle, 1000, $sep)) !== FALSE) {
            $dataRes[] = $row;
        }

        foreach ($csvHeaders as $key => $csvHeader) {
            //because of the empty field in the beginning
            if ($key > 0) {
                foreach ($dataRes as $dataRe) {
                    $day = $csvHeader;
                    $hour = $dataRe[0];
                    $timetable['idTimeslot'] = Timeslot::retrieveTimeslot($day, $hour);
                    if ($dataRe[$key] != '') {
                        $subject = explode('-', $dataRe[$key]);

                        if (isset($subject)) {
                            $timetable['subject'] = $subject[0];
                            $teacherId = Teacher::retrieveByNameSubject($subject[1], $subject[0]);
                            if (isset($teacherId)) {
                                $timetable['idTeacher'] = $teacherId;
                            } else {
                                $timetable['idTeacher'] = 0;
                            }


                        } else {

                            $timetable['subject'] = '';
                            $timetable['idTeacher'] = 0;
                        }


                    } else {
                        $timetable['subject'] = '';
                        $timetable['idTeacher'] = 0;
                    }


                    $exist = Timetable::retrieveTimeslotClass($timetable['idTimeslot'], $timetable['idClass']);

                    if (count($exist) == 0) {

                        Timetable::save($timetable);
                        $save = true;

                    }
                }


            }

        }

        if ($save) {
            return redirect('/timetable/list')->with(['message' => 'Successfull operation!']);
        } else {
            return \Redirect('/')->withErrors([' There is a problem for adding this timetable ']);
        }


    }


    public function list()
    {

        if(\Auth::user()->roleId == User::roleAdmin || \Auth::user()->roleId == User::roleSuperadmin){

            $classrooms = Classroom::retrieve();
            return view('timetable.list', ['classrooms' => $classrooms]);

        }
        else if(\Auth::user()->roleId == User::roleTeacher || \Auth::user()->roleId == User::roleClasscoordinator){

            $myID = \Auth::user()->id;
            $classrooms = Teacher::retrieveTeacherOnlyClasses($myID);
            return view('timetable.list', ['classrooms' => $classrooms]);

        }
        else
            return \Redirect('/')->withErrors([' You have no permission to go to that page']);

    }

    public function show()
    {

        $form = request('frm');

        $id = $form['classId'];

        $class = Classroom::retrieveById($id);

        $timetables = Timetable::retrieveTimeslotData($id);
        if (count($timetables) > 0) {
            foreach ($timetables as $timetable) {
                $data[$timetable->hour][] = $timetable->subject;
            }

            return view('timetable.show' , ['timeTables' => $data, 'classId' => $id]);
        } else {
            if ($class) {
                return \Redirect('/')->withErrors([' There is not any timetable for class ' . $id]);
            } else {
                return \Redirect('/')->withErrors([' Class ' . $id . ' does not exist.']);
            }

        }

    }



    function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }


}
