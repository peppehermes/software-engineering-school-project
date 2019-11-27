<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Material;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\Topic;
use App\Models\Assignment;
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

        return redirect('/student/edit/' . $id)->with(['parent' => 1]);

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

        return redirect('/student/list');

    }

    public function delete($id)
    {

        Student::delete($id);
        return redirect('/student/list');

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


            return view('student.showmarks', ['students' => $students, 'marks' => $marks]);

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

        $studentInfo = Student::retrieveById($id);
        $studentParents[] = $studentInfo->mailParent1;
        $studentParents[] = $studentInfo->mailParent2;

        $userData['roleId'] = Role::retrieveByRole('Parent');
        $parentName1 = $request->input('parentName1');
        $parentEmail1 = $request->input('parentEmail1');
        $parentName2 = $request->input('parentName2');
        $parentEmail2 = $request->input('parentEmail2');
        $p1 = User::retrieveByEmail($parentEmail1);
        $p2 = User::retrieveByEmail($parentEmail2);

        $oldp1 = User::retrieveByEmail($studentInfo->mailParent1);
        $oldp2 = User::retrieveByEmail($studentInfo->mailParent2);


        if ($parentName1 != '' && $parentEmail1 != '') {

            if (isset($oldp1) && !in_array($parentEmail1, $studentParents)) {
                User::deleteById($oldp1->id);
                Student::deleteParentStudent($oldp1->id, $id);
            }


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
            } else {
                $spArray['idParent'] = $p1->id;
                $spArray['idStudent'] = $id;

                $parentStudent = Student::retrieveStudentsForParent($p1->id);
                if (!isset($parentStudent)) {
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
                $spArray['idParent'] = $p2->id;
                $spArray['idStudent'] = $id;

                $parentStudent = Student::retrieveStudentsForParent($p2->id);
                if (!isset($parentStudent)) {
                    Student::saveStudParent($spArray);
                }
            }
        }


        return redirect('/student/list');


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
                Student::saveStudentAttendance($data, $data['studentId'], $data['teacherId'], $classId, $data['lectureDate']);
            } else {

                Student::saveStudentAttendance($data);
            }


        }

        return redirect('/student/attendance/' . $classId . '/' . $data['lectureDate']);
    }

    public function attendancereport($id)
    {
        $myParentID = \Auth::user()->id;

        $student=Student::retrieveById($id);

        $students = Student::retrieveStudentsForParent($myParentID);

        foreach ($students as $student) {
            $stIds[] = $student->id;
        }
        if (!in_array($id, $stIds)) {
            return \Redirect('/')->withErrors([' You dont have permission for another student!']);
        }

        $attendanceReports = Student::retrieveAttendanceReport($id, null, null, null);

        return view('student.attendance_report', ['attendanceReports' => $attendanceReports, 'students' => $students,'student'=>$student]);
    }


}
