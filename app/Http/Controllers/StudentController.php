<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\FinalGrades;
use App\Models\Meeting;
use App\Models\Note;
use App\Models\Material;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timeslot;
use App\Models\Topic;
use App\Models\Assignment;
use App\Models\Timetable;
use App\User;
use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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


        $data = request('frm');

        if ($data['birthday']) {
            $data['birthday'] = Student::convertDate($data['birthday']);
        }


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));

            $data['photo'] = $fileName;
        }
        $id = Student::save($data);

        return redirect('/student/edit/' . $id)->with(['parent' => 1, 'message' => 'Successfull operation!']);

    }

    public function list()
    {

        $students = Student::retrievePagination(10);

        return view('student.list', ['students' => $students]);
    }


    public function edit($id)
    {
        $studentInfo = Student::retrieveById($id);

        if ($studentInfo->birthday) {
            $studentInfo->birthday = Student::convertDateView($studentInfo->birthday);
        }
        if (isset($studentInfo->mailParent1)) {
            $studentInfo->parent1 = User::retrieveByEmail($studentInfo->mailParent1);
        }
        if (isset($studentInfo->mailParent2)) {
            $studentInfo->parent2 = User::retrieveByEmail($studentInfo->mailParent2);
        }

        $classrooms = Classroom::retrieve();


        return view('student.edit', ['studentInfo' => $studentInfo, 'classrooms' => $classrooms]);
    }

    public function update(Request $request, $id)
    {


        $data = request('frm');

        if ($data['birthday']) {
            $data['birthday'] = Student::convertDate($data['birthday']);
        }


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        Student::save($data, $id);

        return redirect('/student/list')->with(['message' => 'Successfull operation!']);

    }

    public function delete($id)
    {

        Student::delete($id);
        return redirect('/student/list')->with(['message' => 'Successfull operation!']);

    }

    public function showmarks($id)
    {
        if (\Auth::user()->roleId == User::roleParent) {

            $myParentID = \Auth::user()->id;

            $students = Student::retrieveStudentsForParent($myParentID);

            foreach ($students as $student) {
                $stIds[] = $student->id;
            }
            if (!in_array($id, $stIds)) {
                return \Redirect('/')->withErrors([' You dont have permission for another student!']);
            }

            $marks = Student::retrieveMarksForStudent($id);

            $average = Student::retrieveAverageForStudent($id);



            return view('student.showmarks', ['students' => $students, 'marks' => $marks, 'averages' => $average]);

        } else {
            return view('student.showmarks');
        }


    }

    public function listTopicforparents($idStud)
    {
        $usId = \Auth::user()->id;


        $idClass = Student::retrieveClassId($idStud);

        $topics = Topic::getTopicByClass($idClass);

        $students = Student::retrieveStudentsForParent($usId);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        return view('student.topiclist', ['topics' => $topics, 'students' => $students]);
    }


    public function listAssignmentforparents($idStud)
    {
        $usId = \Auth::user()->id;


        $idClass = Student::retrieveClassId($idStud);

        $assignments = Assignment::getAssignmentByClass($idClass);

        $students = Student::retrieveStudentsForParent($usId);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        return view('student.assignmentlist', ['assignments' => $assignments, 'students' => $students]);
    }

    public function storeParent(Request $request, $id)
    {

        // retrieve the info of the student
        $studentInfo = Student::retrieveById($id);

        // save the two mails
        $studentParents[] = $studentInfo->mailParent1;
        $studentParents[] = $studentInfo->mailParent2;

        $userData['roleId'] = Role::retrieveByRole('Parent');

        $parentName1 = $request->input('parentName1');
        $parentEmail1 = $request->input('parentEmail1');
        $parentName2 = $request->input('parentName2');
        $parentEmail2 = $request->input('parentEmail2');

        // retrieve the parent 1 from his email
        $p1 = User::retrieveByEmail($parentEmail1);
        // retrieve the parent 2 from his email
        $p2 = User::retrieveByEmail($parentEmail2);

        // retrieve the parent by the email associated to the student
        $oldp1 = User::retrieveByEmail($studentInfo->mailParent1);
        $oldp2 = User::retrieveByEmail($studentInfo->mailParent2);


        if ($parentName1 != '' && $parentEmail1 != '') {

            // if the user was already set and the new email is different from the previous ones
            // delete the parent and his user profile
            if (isset($oldp1) && !in_array($parentEmail1, $studentParents)) {
                User::deleteById($oldp1->id);
                Student::deleteParentStudent($oldp1->id, $id);
            }


            // if the user parent 1 is not set
            if (!isset($p1)) {
                $data['mailParent1'] = $parentEmail1;
                $spArray['idStudent'] = $id;
                Student::save($data, $id);

                $password = User::password_generate(8);
                $userData['password'] = Hash::make($password);
                $userData['email'] = $parentEmail1;
                $userData['name'] = $parentName1;
                $spArray['idParent'] = User::saveUser($userData);

                Student::saveStudParent($spArray);

                //send email
                $to_name = $userData['name'];
                $to_email = $userData['email'];
                $data = array('name' => $to_name, 'password' => $password);
                \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Parent Password');
                    $message->from('sahar.saadatmandii@gmail.com', 'Password');
                });
            } // if the user parent 1 is already set
            else {
                // save the email of the parent in the student profile
                $data['mailParent1'] = $parentEmail1;
                $spArray['idStudent'] = $id;
                Student::save($data, $id);

                // take the id of the parent
                $spArray['idParent'] = $p1->id;
                // take the id of the student
                $spArray['idStudent'] = $id;

                // select all the children of the parent
                $parentStudent = Student::retrieveStudentsForParent($p1->id);

                $childrenOfParentId = array();
                // take all the children associated to this parent
                foreach ($parentStudent as $children)
                    array_push($childrenOfParentId, $children->studentId);
                // if the student is not already associated to the parent, save it as a child of the parent
                if (!in_array($id, $childrenOfParentId)) {
                    Student::saveStudParent($spArray);
                }
            }
        }


        if ($parentName2 != '' && $parentEmail2 != '') {

            if (isset($oldp2) && !in_array($parentEmail2, $studentParents)) {
                User::deleteById($oldp2->id);
                Student::deleteParentStudent($oldp2->id, $id);
            }


            if (!isset($p2)) {

                $data1['mailParent2'] = $parentEmail2;
                $spArray['idStudent'] = $id;
                Student::save($data1, $id);

                $userData['name'] = $parentName2;
                $password = User::password_generate(8);
                $userData['password'] = Hash::make($password);
                $userData['email'] = $parentEmail2;

                $spArray['idStudent'] = Student::save($data1, $id);

                $spArray['idParent'] = User::saveUser($userData);
                Student::saveStudParent($spArray);

                //send email
                $to_name = $userData['name'];
                $to_email = $userData['email'];
                $data1 = array('name' => $to_name, 'password' => $password);
                \Mail::send('email.mail', $data1, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Parent Password');
                    $message->from('sahar.saadatmandii@gmail.com', 'Password');
                });
            } else {
                // save the email of the parent in the student profile
                $data1['mailParent2'] = $parentEmail2;
                $spArray['idStudent'] = $id;
                Student::save($data, $id);

                $spArray['idParent'] = $p2->id;
                $spArray['idStudent'] = $id;

                $parentStudent = Student::retrieveStudentsForParent($p2->id);

                $childrenOfParentId = array();
                // take all the children associated to this parent
                foreach ($parentStudent as $children)
                    array_push($childrenOfParentId, $children->studentId);
                // if the student is not already associated to the parent, save it as a child of the parent
                if (!in_array($id, $childrenOfParentId)) {
                    Student::saveStudParent($spArray);
                }
            }
        }


        return redirect('/student/list')->with(['message' => 'Successfull operation!']);


    }


    public function listMaterialforparents($idStud)
    {
        $usId = \Auth::user()->id;


        $idClass = Student::retrieveClassId($idStud);

        $material = Material::getMaterialByClass($idClass);

        $students = Student::retrieveStudentsForParent($usId);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        return view('student.materiallist', ['materials' => $material, 'students' => $students]);
    }

    public function attendance($classId, $date)
    {

        $teacherId = \Auth::user()->id;

        $classRooms = Teacher::retrieveTeacherClass($teacherId);

        $students = Student::retrieveStudentClass($classId);


        foreach ($students as $student) {
            $student->attendance = Student::retrieveStudentAttendance($student->id, null, $classId, $date);
        }

        $dateview = Student::convertDateView($date);

        return view('student.attendance', ['students' => $students, 'classRooms' => $classRooms, 'classId' => $classId, 'date' => $dateview]);
    }

    public function saveattendance($classId)
    {
        $teacherId = \Auth::user()->id;
        $students = Student::retrieveStudentClass($classId);

        foreach ($students as $student) {
            $data = request('frm' . $student->id);

            $data['lectureDate'] = request('lectureDate');

            if (!isset($data['status'])) {
                $data['status'] = 'absent';
            } else {
                $data['status'] = 'present';
            }
            $data['classId'] = $classId;
            $data['teacherId'] = $teacherId;
            $data['studentId'] = $student->id;
            $data['lectureDate'] = Student::convertDate($data['lectureDate']);

            $st = Student::retrieveAttendance($student->id, $teacherId, $classId, $data['lectureDate']);

            if (isset($st)) {
                //update
                Student::saveStudentAttendance($data, $data['studentId'], $data['teacherId'], $classId, $data['lectureDate']);
            } else {
                //insert
                Student::saveStudentAttendance($data);
            }


        }

        return redirect('/student/attendance/' . $classId . '/' . $data['lectureDate'])->with(['message' => 'Successfull operation!']);
    }

    public function attendancereport($id)
    {
        $myParentID = \Auth::user()->id;

        $student = Student::retrieveById($id);

        $students = Student::retrieveStudentsForParent($myParentID);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($id, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        $attendanceReports = Student::retrieveAttendanceReport($id, null, null, null);

        return view('student.attendance_report', ['attendanceReports' => $attendanceReports, 'students' => $students, 'student' => $student]);
    }

    public function shownotes($id)
    {
        if (\Auth::user()->roleId == User::roleParent) {

            $myParentID = \Auth::user()->id;

            $students = Student::retrieveStudentsForParent($myParentID);

            foreach ($students as $student) {
                $stIds[] = $student->id;
            }
            if (!in_array($id, $stIds)) {
                return \Redirect('/')->withErrors([' You dont have permission for another student!']);
            }

            $notes = Note::retrieveNotesForStudent($id);

            return view('student.shownotes', ['students' => $students, 'notes' => $notes]);

        } else {
            return view('student.shownotes');
        }
    }

    public function timetableForStudent($idStud)
    {

        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }


        $class = Classroom::retrieveByStudentId($idStud);

        $timetables = Timetable::retrieveTimeslotData($class);
        if (count($timetables) > 0) {
            foreach ($timetables as $timetable) {
                $data[$timetable->hour][] = $timetable->subject;
            }

            return view('student.timetablelist', ['timeTables' => $data, 'classId' => $class, 'students' => $students]);
        } else {
            if ($class) {
                return \Redirect('/')->withErrors([' There is not any timetable for class ' . $class]);
            } else {
                return \Redirect('/')->withErrors([' Class ' . $class . ' is not exist.']);
            }

        }
    }

    //retrieve all teachers that teach in that student's class
    public function chooseteacher($idStud)
    {

        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        $teachers = Teacher::retrieveTeachersForStudent($idStud);

        return view('meetings.choose', ['students' => $students, 'teachers' => $teachers, 'idStud' => $idStud]);
    }


    //show the view of meeting slots for that teacher
    public function seeTeacherMeetingSlot($idStud)
    {


        //carrying over children's id for parent's sidebar
        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($idStud, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        //retrieving teacherID from the form
        $form = request('frm');
        $teacherID = $form['teachId'];
        $week = $form['week'];
        $year_week=explode('-',$week);

        $date1 = date( "l, M jS, Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'1') ); // First day of week
        $date2 = date( "l, M jS, Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'7') ); // Last day of week


        $times = Timeslot::retrieve();
        $bool = 1;
        //$provided = Meeting::retrieveMeetingperTeacher($teacherID); // already provided timeslots
        $provided = Meeting::retrieveWeeklyMeetingperTeacher($teacherID, $week);// already provided timeslots
        foreach ($times as $time) {
            $data[$time->hour][] = $time->id;
        }
        $timeslots = Teacher::retrieveTimeslots($teacherID);
        $teach = Teacher::retrieveById($teacherID);

        if (count($timeslots) > 0) {

            return view('meetings.book', ['students' => $students, 'timeslots' => $timeslots, 'times' => $data,
                                                'teach' => $teach, 'bool' => $bool, 'provided' => $provided, 'week' => $week,'date1'=>$date1,'date2'=>$date2,
                                                'idStud' => $idStud]);

        } else
            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);

    }

    // return all meetings booked from that parent
    public function meetingListForParents()
    {

        //carrying over children's id for parent's sidebar
        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        $meetings = Meeting::retrieveMeetingperParent($myParentID);
        foreach ($meetings as $meeting) {
            $week = $meeting->idweek;
            $year_week=explode('-',$week);

            $date1 = date( "d M Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'1') ); // First day of week
            $date2 = date( "d M Y", strtotime($year_week[0]."W". ltrim($year_week[1],'W').'7') ); // Last day of week
            $meeting->weekDate=$date1.' / '.$date2;
        }

        return view('meetings.listforparents', ['students' => $students, 'meetings' => $meetings]);

    }

    // store the meeting booked by that parent
    public function storeMeetingForParent()
    {

        //carrying over children's id for parent's sidebar
        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        $slots = json_decode(stripslashes($_POST['data']));
        $week=(stripslashes($_POST['week']));
        $studentID=(stripslashes($_POST['myStudent']));
        $teacherID=(stripslashes($_POST['teacher']));

        $booked = Meeting::retrieveMeetingTeachForParents($teacherID, $myParentID);

        if (count($booked) > 0) {

            $message = 'Sorry, you have already a meeting planned with that Teacher!';
            return $message;
        }

        else {
            $data['idTeacher'] = $teacherID;
            $data['idweek'] = $week;
            $data['isBooked'] = 1;
            $data['idParent'] = $myParentID;
            $data['idStud'] = $studentID;

            foreach ($slots as $d) {
                $data['idTimeslot'] = $d;
                Meeting::updateMeetingStatus($data);
            }
            return 0;
        }

    }

    // store the meeting booked by that parent
    public function freeMeetingForParent()
    {

        //carrying over children's id for parent's sidebar
        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        $slots = json_decode(stripslashes($_POST['data']));
        $week=(stripslashes($_POST['week']));
        $teacherID=(stripslashes($_POST['teacher']));

        $booked = Meeting::retrieveMeetingTeachForParents($teacherID, $myParentID);

        if (count($booked) != 1) {

            $message = 'Sorry, you do not have any meetings booked with that teacher!';
            return $message;
        }

        else {
            $data['idTeacher'] = $teacherID;
            $data['idweek'] = $week;
            $data['isBooked'] = 0;
            $data['idParent'] = null;
            $data['idStud'] = null;

            foreach ($slots as $d) {
                $data['idTimeslot'] = $d;
                Meeting::updateMeetingStatus($data);
            }
            return 0;
        }

    }


    public function listFinalGradesforparents($idStud)
    {
        $myParentID = \Auth::user()->id;
        $students = Student::retrieveStudentsForParent($myParentID);

        $idClass = Student::retrieveClassId($idStud);
        $student = Student::retrieveStudentById($idStud);

        $subjects = Subject::retrieve();
        $finalGrades = FinalGrades::retrieveCurrentByClassId($idClass);

        if ($finalGrades->count()) {
            // Final grades already stored for that class
            return view('/student/showfinalgrades',
                ['classId' => $idClass,
                    'studentsG' => $student,
                    'subjects' => $subjects,
                    'finalgrades' => $finalGrades,
                    'students'=>$students
                ]);
        } else {
            // Final grades not yet stored for that class
            return \Redirect('/')->withErrors([' Final Grades not yet inserted.']);
        }
    }


}
