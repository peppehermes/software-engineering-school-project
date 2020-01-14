<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Communications;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
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

        $constraint = array();

        // Check if the file was uploaded
        if (!$file->isValid()) {
            return \Redirect('/')->withErrors([' There is a problem for adding this timetable ']);
        }

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

                            //Initialization of array of subjects
                            $allsubjects = Subject::retrieveSubjectsForClass($timetable['idClass']);


                            foreach ($allsubjects as $subject) {


                                // $hours is used to store all effective hours inserted through the form
                                $hours[$subject->subject] = 0;

                                // $tothours is used to store all established hours, used to check the second constraint

                                $tothours[$subject->subject] = Subject::retrieveTotHoursForSubject($subject->id);

                            }



                        } else {

                            $timetable['subject'] = '';
                            $timetable['idTeacher'] = 0;
                            $tothours['subject']=0;
                        }


                    } else {
                        $timetable['subject'] = '';
                        $timetable['idTeacher'] = 0;
                        $tothours['subject']=0;
                    }


                    $exist = Timetable::retrieveTimeslotClass($timetable['idTimeslot'], $timetable['idClass']);


                    if (count($exist) == 0) {

                        $id=Timetable::save($timetable);
                        $save = true;

                        if($id==0){
                            $constraint_teacher_timeslot_error=1;
                        }

                    }
                }


            }

        }

        //First, I check if there is a violation of constraints for all timeslots I'm trying to insert
        if($constraint_teacher_timeslot_error){
            return \Redirect('/')->withErrors([' There was a constraint violation (TEACHER IN MULTIPLE CLASSES), check properly the timetables']);
        }


        //SECOND CONSTRAINT: If the amount of hours of each subject is different than the one established,
        // the constraint was violated
        foreach ($allsubjects as $subject) {

            if ($hours[$subject->subject] != $tothours[$subject->subject])
                return \Redirect('/')->withErrors([' There was a constraint violation (HOUR ASSIGNMENT NOT COHERENT), check properly the timetables']);

        }


        if ($save) {
            return redirect('/timetable/list')->with(['message' => 'Successfull operation!']);
        } else {
            return \Redirect('/')->withErrors([' There is a problem for adding this timetable ']);
        }


    }


    public function list()
    {

        if (\Auth::user()->roleId == User::roleAdmin || \Auth::user()->roleId == User::roleSuperadmin) {

            $classrooms = Classroom::retrieve();
            return view('timetable.list', ['classrooms' => $classrooms]);

        } else if (\Auth::user()->roleId == User::roleTeacher || \Auth::user()->roleId == User::roleClasscoordinator) {

            $myID = \Auth::user()->id;
            $classrooms = Teacher::retrieveTeacherOnlyClasses($myID);
            return view('timetable.list', ['classrooms' => $classrooms]);

        } else
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

            return view('timetable.show', ['timeTables' => $data, 'classId' => $id]);
        } else {
            if ($class) {
                return \Redirect('/')->withErrors([' There is not any timetable for class ' . $id]);
            } else {
                return \Redirect('/')->withErrors([' Class ' . $id . ' does not exist.']);
            }

        }

    }

    //Lets the admin choose the class for the manual insertion of timetables
    public function chooseclass()
    {

        if (\Auth::user()->roleId == User::roleAdmin || \Auth::user()->roleId == User::roleSuperadmin) {

            $classrooms = Classroom::retrieve();
            return view('timetable.chooseclass', ['classrooms' => $classrooms]);

        } else
            return \Redirect('/')->withErrors([' You have no permission to go to that page']);

    }

    //Returns values for the form for the manual insertion of timetables
    public function addmanual()
    {

        $form = request('frm');

        $id = $form['classId'];

        $subjects = Subject::retrieveSubjectsForClass($id);
        return view('timetable.addmanual', ['subjects' => $subjects, 'classId' => $id]);


    }

    //Checks if there is a violation of constraint in the insertion of a new timetable
    //If not, inserts or updates the timetable of that class
    public function storemanual($classID)
    {

        $constraint_violation = 0;

        //Initialization of array of subjects
        $allsubjects = Subject::retrieveSubjectsForClass($classID);

        foreach ($allsubjects as $subject) {

            // $hours is used to store all effective hours inserted through the form
            $hours[$subject->subject] = 0;

            // $tothours is used to store all established hours, used to check the second constraint
            $tothours[$subject->subject] = Subject::retrieveTotHoursForSubject($subject->id);
        }

        //First, I check if there is a violation of constraints for all timeslots I'm trying to insert
        for ($i = 1; $i < 31; $i++) {

            $teachingID = request('frm' . $i);
            $subject = Teaching::retrieveSubject($teachingID);

            if ($subject != 'Free') {

                $timeslotID = $i;
                $teacherID = Teaching::retrieveTeacher($teachingID);

                //Returns no tuples if that teacher is not teaching in another class on that same timeslot
                $result[$i] = Timetable::checkTimetableConstraint($classID, $timeslotID, $teacherID);

                //FIRST CONSTRAINT: If at least a tuple is returned, the constraint was violated
                if (!$result[$i]->isEmpty())
                    $constraint_violation = 1;
            }

            //Update the counter of hours for that subject
            $hours[$subject]++;

        }

        if ($constraint_violation)
            return \Redirect('/')->withErrors([' There was a constraint violation (TEACHER IN MULTIPLE CLASSES), check properly the timetables']);


        //SECOND CONSTRAINT: If the amount of hours of each subject is different than the one enstablished,
        // the constraint was violated
        foreach ($allsubjects as $subject) {

            if ($hours[$subject->subject] != $tothours[$subject->subject])
                return \Redirect('/')->withErrors([' There was a constraint violation (HOUR ASSIGNMENT NOT COHERENT), check properly the timetables']);

        }


        //If no constraints were violated, I can proceed with the insert or update of the timetable
        for ($i = 1; $i < 31; $i++) {

            $teachingID = request('frm' . $i);
            $timeslotID = $i;

            $subject = Teaching::retrieveSubject($teachingID);


            if ($subject != 'Free') {

                $teacherID = Teaching::retrieveTeacher($teachingID);
                Timetable::saveManual($classID, $timeslotID, $teacherID, $subject);
            } else {
                Timetable::saveManualFreeHour($classID, $timeslotID);
            }

        }

        return redirect('timetable/chooseclass')->with(['message' => 'Timetable succesfully updated!']);

    }


    function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }


}
