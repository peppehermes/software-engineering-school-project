<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\FinalGrades;
use App\Models\Role;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\Note;
use App\Models\Mark;
use App\Models\Timeslot;
use App\Models\Meeting;
use App\User;
use DB;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        define("MESSAGE", "message");
        define("CLASSES", "classes");
        define("EMAIL", "email");
        define("BIRTHDAY", "birthday");
        define("USER_ID", "userId");
        define("PHOTO", "photo");
        define("DATE_HOUR_FORMAT", "YmdHis");
        define("DATE_FORMAT", "Y-m-d");
        define("PUBLIC_UPLOADS", "public_uploads");
        define("SUBJECT", "subject");
        define("SUBJECTS", "subjects");
        define("ID_TEACH", "idTeach");
        define("SUCCESS", "Successful operation!");
        define("ID_CLASS", "idClass");
        define("CLASS_ID", "classId");
        define("LECTURE_DATE", "lecturedate");
        define("TEACHER", "teacher");
        define("DEADLINE", "deadline");
        define("ATTACHMENT", "attachment");
        define("ID_STUDENT", "idStudent");
        define("STUDENTS", "students");
        define("TOPIC", "topic");
        define("MATERIAL", "material");
        define("ID_WEEK", "idweek");
        define("ID_TIMESLOT", "idTimeslot");
        define("FINAL_GRADES_SHOW", "/finalgrades/show");
        define("FINAL_GRADES", "finalgrades");
        $this->middleware('auth');
    }

    public function add()
    {
        $classes = Classroom::retrieve();
        return view('teacher.add', [CLASSES => $classes]);
    }

    public function store(Request $request)
    {

        $data = request('frm');
        $dataT = request('frmT');

        if ($data) {
            //create user
            $userData[EMAIL] = strtolower(request(EMAIL));
            $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];
            $userData['roleId'] = Role::retrieveByRole('Teacher');

            $password = $this->password_generate(8);
            $userData['password'] = Hash::make($password);
            $userId = User::saveUser($userData);

            if ($data[BIRTHDAY]) {
                $data[BIRTHDAY] = Student::convertDate($data[BIRTHDAY]);
            }


            $data[USER_ID] = $userId;

            if ($request->file(PHOTO)) {

                $cover = $request->file(PHOTO);

                $extension = $cover->getClientOriginalExtension();
                $fileName = date(DATE_HOUR_FORMAT) . '.' . $extension;
                \Storage::disk(PUBLIC_UPLOADS)->put($fileName, \File::get($cover));


                $data[PHOTO] = $fileName;
            }

            $Teachid = Teacher::save($data);

            foreach ($dataT[ID_CLASS] as $classId) {
                if (strpos($dataT[SUBJECT], '-')) {
                    $subjects = explode('-', $dataT[SUBJECT]);
                    foreach ($subjects as $subject) {
                        $dataTa[ID_TEACH] = $Teachid;
                        $dataTa[SUBJECT] = $subject;
                        $dataTa[ID_CLASS] = $classId;

                        Teacher::saveTeaching($dataTa);
                    }
                } else {
                    $dataTa[ID_TEACH] = $Teachid;
                    $dataTa[ID_CLASS] = $classId;
                    $dataTa[SUBJECT] = $dataT[SUBJECT];
                    Teacher::saveTeaching($dataTa);
                }
            }

        }

        //send email
        $to_name = $userData['name'];
        $to_email = $userData[EMAIL];
        $data = array('name' => $to_name, 'password' => $password);
        \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Teacher Password');
            $message->from('sahar.saadatmandii@gmail.com', 'Password');
        });

        return redirect('/teacher/list')->with([MESSAGE => 'Successful operation!']);
    }

    public function list()
    {
        $teachers = Teacher::retrievePagination(10);

        return view('teacher.list', ['teachers' => $teachers]);
    }

    public function edit($id)
    {
        $classes = Classroom::retrieve();
        $teacherInfo = Teacher::retrieveById($id);
        $teacherEmail = User::retrieveById($teacherInfo->userId);
        if ($teacherInfo->birthday) {
            $teacherInfo->birthday = Student::convertDateView($teacherInfo->birthday);
        }


        $teacherInfo->email = $teacherEmail->email;

        $teachings = Teacher::retrieveTeaching($id);

        foreach ($teachings as $teaching) {
            $subjects[] = $teaching->subject;
            $teacherInfo->idClass[] = $teaching->idClass;
        }
        $subjects = array_unique($subjects);

        $teacherInfo->subject = implode('-', $subjects);

        return view('teacher.edit', ['teacherInfo' => $teacherInfo, CLASSES => $classes]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::retrieveById($id);

        $data = request('frm');
        $dataT = request('frmT');

        if ($data[BIRTHDAY]) {
            $data[BIRTHDAY] = Student::convertDate($data[BIRTHDAY]);
        }
        $userData[EMAIL] = strtolower(request(EMAIL));
        $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];

        User::saveUser($userData, $teacher->userId);

        if ($request->file(PHOTO)) {

            $cover = $request->file(PHOTO);

            $extension = $cover->getClientOriginalExtension();
            $fileName = date(DATE_HOUR_FORMAT) . '.' . $extension;
            \Storage::disk(PUBLIC_UPLOADS)->put($fileName, \File::get($cover));


            $data[PHOTO] = $fileName;
        }
        Teacher::save($data, $id);

        Teacher::deleteTeachingTeacherId($id);
        foreach ($dataT[ID_CLASS] as $classId) {

            if (strpos($dataT[SUBJECT], '-')) {
                $subjects = explode('-', $dataT[SUBJECT]);
                foreach ($subjects as $subject) {
                    $dataTa[ID_TEACH] = $id;
                    $dataTa[SUBJECT] = $subject;
                    $dataTa[ID_CLASS] = $classId;

                    Teacher::saveTeaching($dataTa);
                }
            } else {

                $dataTa[ID_TEACH] = $id;
                $dataTa[ID_CLASS] = $classId;
                $dataTa[SUBJECT] = $dataT[SUBJECT];

                Teacher::saveTeaching($dataTa);
            }
        }


        return redirect('/teacher/list')->with([MESSAGE => 'Successful operation!']);
    }

    public function delete($id)
    {
        $teacherInfo = Teacher::retrieveById($id);
        Teacher::delete($id);
        User::deleteById($teacherInfo->userId);


        return redirect('/teacher/list')->with([MESSAGE => SUCCESS]);
    }

    public function password_generate($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    public function listtopic()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $topics = Topic::retrieveTeachersPagination($teachId);
        return view('topic.list', ['topics' => $topics]);
    }

    public function storetopic(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = request(LECTURE_DATE);
            $data['date'] = Student::convertDate($data['date']);
            $data[ID_CLASS] = request(ID_CLASS);
            $data[SUBJECT] = request(SUBJECT);
            $data[ID_TEACH] = DB::table(TEACHER)->where(USER_ID, $usId)->value('id');
            Topic::save($data);
        }
        return redirect('/topic/list')->with([MESSAGE => 'Successful operation!']);
    }

    public function addtopic()
    {
        $usId = \Auth::user()->id;
        $date = date(DATE_FORMAT);
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('topic.add', [CLASSES => $classes, SUBJECTS => $subjects, 'date' => $dateview]);
    }

    public function storeassignment(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        $i = 1;

        if ($data) {
            $data[DEADLINE] = request(DEADLINE);
            $data['date'] = request(LECTURE_DATE);
            $data['date'] = Student::convertDate($data['date']);
            $data[DEADLINE] = Student::convertDate($data[DEADLINE]);
            $data[ID_CLASS] = request(ID_CLASS);
            $data[SUBJECT] = request(SUBJECT);
            $data[ID_TEACH] = Teacher::retrieveId($usId);
            if ($request->file(ATTACHMENT)) {

                $cover = $request->file(ATTACHMENT);
                foreach ($cover as $cov) {
                    $extension = $cov->getClientOriginalExtension();
                    $fileName = date(DATE_HOUR_FORMAT) . '(' . $i . ')' . '.' . $extension;
                    \Storage::disk(PUBLIC_UPLOADS)->put($fileName, \File::get($cov));
                    if ($i == 1) {
                        $data[ATTACHMENT] = $fileName;
                    } else {
                        $data[ATTACHMENT] = $data[ATTACHMENT] . '/' . $fileName;
                    }
                    $i++;
                }
            }
            Assignment::save($data);
        }
        return redirect('/assignment/list')->with([MESSAGE => SUCCESS]);
    }


    public function addassignment()
    {
        $usId = \Auth::user()->id;
        $date = date(DATE_FORMAT);
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('assignments.add', [CLASSES => $classes, SUBJECTS => $subjects, 'date' => $dateview]);
    }


    public function listassignment()
    {
        $usId = \Auth::user()->id;
        $attachment[] = 0;
        $index = 0;
        $index1 = 1;
        $teachId = Teacher::retrieveId($usId);
        $assignments = Assignment::retrieveTeachersPagination($teachId);
        return view('assignments.list', ['assignments' => $assignments, ATTACHMENT => $attachment,
            'index' => $index, 'index1' => $index1]);
    }

    public function storemark(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = request(LECTURE_DATE);
            $data['date'] = Student::convertDate($data['date']);
            $data[ID_CLASS] = request(ID_CLASS);
            $data[SUBJECT] = request(SUBJECT);
            $data['mark'] = request('mark');
            $data[ID_STUDENT] = request(ID_STUDENT);
            $data[ID_TEACH] = DB::table(TEACHER)->where(USER_ID, $usId)->value('id');
            Mark::save($data);
        }
        return redirect('/mark/list')->with([MESSAGE => 'Successful operation!']);


    }

    public function addnewmark(Request $request)
    {


        $usId = \Auth::user()->id;

        $classRooms = Teacher::retrieveTeacherClass($usId);

        $students = Student::retrieveStudentClass(request(ID_CLASS));

        $classId = request(ID_CLASS);
        $date = request(LECTURE_DATE);
        $subject = request(SUBJECT);
        $topic = request(TOPIC);
        $date2 = Student::convertDate($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);

        $subjectsClass = Teacher::retrieveTeachingClass($teachId, $classId);


        foreach ($students as $student) {
            $mark = Mark::retrieveTeachersSubjectTopic($teachId, $subject, $topic, $date2, $student->id);
            if ($mark) {
                $student->mark = $mark->mark;
            } else {
                $student->mark = NULL;
            }

        }


        return view('marks.addnewmark', [STUDENTS => $students, 'classRooms' => $classRooms,
            CLASS_ID => $classId, 'date' => $date, SUBJECT => $subject,
            TOPIC => $topic, CLASSES => $classes, SUBJECTS => $subjects, 'subjectsClass' => $subjectsClass]);


    }

    public function storenewmark(Request $request)
    {

        $usId = \Auth::user()->id;
        $students = Student::retrieveStudentClass(request(CLASS_ID));


        foreach ($students as $student) {

            $data = request('frm' . $student->id);
            $data2 = request('frm2' . $student->id);


            if ($data && isset($data['mark']) && isset($data2['status'])) {
                $data[SUBJECT] = request(SUBJECT);
                $data[TOPIC] = request(TOPIC);
                $data[ID_CLASS] = request(CLASS_ID);

                $data['date'] = request('date');
                $data['date'] = Student::convertDate($data['date']);
                $data[ID_TEACH] = Teacher::retrieveId($usId);

                $mark = Mark::retrieveTeachersSubjectTopic($data[ID_TEACH], $data[SUBJECT],
                    $data[TOPIC], $data['date'], $student->id);

                if ($mark) {
                    Mark::save($data, $mark->id);
                } else {
                    Mark::save($data);
                }


            }
        }
        return redirect('/mark/classlist')->with([MESSAGE => 'Successful operation!']);


    }

    public function listclasses()
    {
        $usId = \Auth::user()->id;
        $date = date(DATE_FORMAT);
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.classes', [CLASSES => $classes, 'studId' => $studId, SUBJECTS => $subjects, 'date' => $dateview]);
    }


    public function addmark()
    {
        $usId = \Auth::user()->id;
        $date = date(DATE_FORMAT);
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.add', [CLASSES => $classes, 'studId' => $studId, SUBJECTS => $subjects, 'date' => $dateview]);
    }


    public function listmark()
    {
        $usId = \Auth::user()->id;
        $classId = request(CLASS_ID);
        $teachId = Teacher::retrieveId($usId);
        $marks = Mark::retrieveTeachersClasses($teachId, $classId);
        return view('marks.list', ['marks' => $marks, CLASS_ID => $classId]);
    }

    public function classlist()
    {
        $myID = \Auth::user()->id;
        $classrooms = Teacher::retrieveTeacherOnlyClasses($myID);
        return view('marks.classlist', ['classrooms' => $classrooms]);
    }


    public function addmaterial()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        return view('suppmaterial.add', [CLASSES => $classes, SUBJECTS => $subjects]);
    }

    public function storematerial(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        $i = 1;

        if ($data) {
            //create topic
            $data['date'] = date(DATE_FORMAT);
            $data[ID_CLASS] = request(ID_CLASS);
            $data[SUBJECT] = request(SUBJECT);
            $data[ID_TEACH] = DB::table(TEACHER)->where(USER_ID, $usId)->value('id');

            if ($request->file(MATERIAL)) {

                $cover = $request->file(MATERIAL);
                foreach ($cover as $cov) {
                    $extension = $cov->getClientOriginalExtension();
                    $fileName = date(DATE_HOUR_FORMAT) . '(' . $i . ')' . '.' . $extension;
                    \Storage::disk(PUBLIC_UPLOADS)->put($fileName, \File::get($cov));
                    if ($i == 1) {
                        $data[MATERIAL] = $fileName;
                    } else {
                        $data[MATERIAL] = $data[MATERIAL] . '/' . $fileName;
                    }
                    $i++;
                }
            }

            Material::save($data);
        }
        return redirect('/material/list')->with([MESSAGE => 'Successful operation!']);
    }

    public function listmaterial()
    {
        $usId = \Auth::user()->id;
        $attachment[] = 0;
        $index = 0;
        $index1 = 1;
        $teachId = Teacher::retrieveId($usId);
        $materials = Material::retrieveTeachersPagination($teachId);
        return view('suppmaterial.list', ['materials' => $materials, ATTACHMENT => $attachment, 'index' => $index, 'index1' => $index1]);
    }

    public function writenote()
    {
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('notes.write', [CLASSES => $classes, 'stud' => $studId, SUBJECTS => $subjects]);
    }

    public function storenote(Request $request)
    {
        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create note
            $data['date'] = date(DATE_FORMAT);
            $data[ID_CLASS] = request(ID_CLASS);
            $data[ID_STUDENT] = request(ID_STUDENT);
            $data[SUBJECT] = request(SUBJECT);
            $data[ID_TEACH] = DB::table(TEACHER)->where(USER_ID, $usId)->value('id');

            Note::save($data);
        }
        return redirect('/notes/list')->with([MESSAGE => 'Successful operation!']);
    }

    public function listnotes()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $notes = Note::retrieveTeachersPagination($teachId);

        return view('notes.list', ['notes' => $notes]);
    }


    public function listtimeslot(Request $request)
    {
        $form = request('frm');
        $week = $form['week'];
        $year_week = explode('-', $week);
        $date1 = date("l, M jS, Y", strtotime($year_week[0] . "W" . ltrim($year_week[1], 'W') . '1')); // First day of week
        $date2 = date("l, M jS, Y", strtotime($year_week[0] . "W" . ltrim($year_week[1], 'W') . '7')); // Last day of week

        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $exist = Meeting::retrieveMeetingperTeacher($teachId);
        $teach = Teacher::retrieveById($teachId);
        if (count($exist) == 0) {
            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . ' ' . $teach->lastName . ' first provide the two timeslots.']);
        } else {
            $times = Timeslot::retrieve();
            $bool = 1;
            $provided = Meeting::retrieveWeeklyMeetingperTeacher($teachId, $week);// already provided timeslots
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);

            if (count($timeslots) > 0) {
                return view('meetings.list', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool, 'provided' => $provided, 'week' => $week, 'date1' => $date1, 'date2' => $date2]);
            } else {
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);
            }
        }
    }

    public function addtimeslot()
    {

        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $times = Timeslot::retrieve();
        $bool = 1;
        $teach = Teacher::retrieveById($teachId);
        $provided = Meeting::retrieveMeetingperTeacher($teachId);

        if (count($provided) > 0) {
            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . ' ' . $teach->lastName . ' has already provided the two timeslots']);
        } else {
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);
            if (count($timeslots) > 0) {
                return view('meetings.add', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool,]);
            } else {
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);
            }
        }
    }

    public function addweek()
    {
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $teach = Teacher::retrieveById($teachId);
        return view('meetings.addweek', ['teach' => $teach]);
    }


    public function storetimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week = (stripslashes($_POST['week']));
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $provided = Meeting::retrieveWeeklyMeetingperTeacher($teachId, $week);

        if ((count($provided) + count($slots)) > 3) {
            return 'Too many timeslots provided, please provide at most 3!';
        } else {
            $data['idTeacher'] = $teachId;
            $data[ID_WEEK] = $week;

            foreach ($slots as $d) {
                $data[ID_TIMESLOT] = $d;
                Meeting::save($data);
            }
            return 0;
        }

    }

    public function storealltimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week = (stripslashes($_POST['week']));
        $year = date("Y");
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $data['idTeacher'] = $teachId;
        // if we are after September
        if ($week >= 37) {
            // between september and the end of the year
            for ($i = $week; $i < 52; $i++) {
                $data[ID_WEEK] = ($year . '-W' . $i);
                foreach ($slots as $d) {
                    $data[ID_TIMESLOT] = $d;
                    Meeting::save($data);
                }
            }
            // between january and end of the school in june
            for ($i = 2; $i < 29; $i++) {
                if ($i < 10)
                    $data[ID_WEEK] = $year + 1 . '-W' . '0' . $i;
                else
                    $data[ID_WEEK] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data[ID_TIMESLOT] = $d;
                    Meeting::save($data);
                }
            }
        } // if we are after January
        else if ($week > 1 && $week < 28) {
            for ($i = $week; $i < 29; $i++) {
                if ($i < 10)
                    $data[ID_WEEK] = $year + 1 . '-W' . '0' . $i;
                else
                    $data[ID_WEEK] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data[ID_TIMESLOT] = $d;
                    Meeting::save($data);
                }
            }
        } // we are in the first week of january
        else if ($week == 1) {
            for ($i = $week + 1; $i < 29; $i++) {
                if ($i < 10)
                    $data[ID_WEEK] = $year + 1 . '-W' . '0' . $i;
                else
                    $data[ID_WEEK] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data[ID_TIMESLOT] = $d;
                    Meeting::save($data);
                }
            }
        } // between june and september,it's not possible to provide
        else
            return 1;
    }

    public function freetimeslot()
    {
        $slots = json_decode(stripslashes($_POST['data']));
        $week = (stripslashes($_POST['week']));
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);


        foreach ($slots as $d) {
            Meeting::delete_per_teacher($d, $teachId, $week);
        }
    }

    /*
     *  This function is used by the class coordinator
     *  It redirects to the view in which he can insert the final grades
     *  The class coordinated by the teacher, the students in it
     *  and the relative subjects are passed to the view
     */
    public function insertFinalGrades()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $classId = Classroom::retrieveByClassCoordinator($teachId);
        $subjects = Subject::retrieve();
        $students = Student::retrieveStudentClass($classId);
        $finalGrades = FinalGrades::retrieveCurrentByClassId($classId);

        if ($finalGrades->count()) { // The count() method returns the number of items of a collection
            // Final grades already stored for that class
            return view(FINAL_GRADES_SHOW, [CLASS_ID => $classId,
                STUDENTS => $students,
                SUBJECTS => $subjects,
                FINAL_GRADES => $finalGrades
            ])->with([MESSAGE => 'Final grades already stored!']);
        } else {
            // Final grades not yet stored for that class
            return view('finalgrades.insert',
                [CLASS_ID => $classId,
                    STUDENTS => $students,
                    SUBJECTS => $subjects
                ]);
        }
    }

    /*
     *  This function is used by the class coordinator
     *  It's used to store the final grades
     *  It retrieves the data from the form of route finalgrades/insert
     */
    public function storeFinalGrades($classId)
    {
        $students = Student::retrieveStudentClass($classId);
        $subjects = Subject::retrieve();
        $finalGrades = FinalGrades::retrieveCurrentByClassId($classId);

        if ($finalGrades->count()) { // The count() method returns the number of items of a collection
            // Final grades already stored for that class
            return view(FINAL_GRADES_SHOW, [CLASS_ID => $classId,
                STUDENTS => $students,
                SUBJECTS => $subjects,
                FINAL_GRADES => $finalGrades
            ])->with([MESSAGE => 'Final grades already stored!']);
        } else {
            // Final grades not yet stored for that class
            foreach ($students as $student) {
                foreach ($subjects as $subject) {
                    // The key of the request is made by the id of the student and the id of the subject
                    $data = request('frm' . $student->id . $subject->subjectId);

                    // Insert year and data into the data array
                    $data['year'] = date('Y');
                    $data[ID_CLASS] = $classId;

                    // Insert into finalgrades table
                    FinalGrades::save($data);
                }
            }
        }

        return redirect(FINAL_GRADES_SHOW)->with([MESSAGE => SUCCESS]);
    }

    /*
     *  This function is used by the class coordinator
     *  It's used to show the final grades
     *  It retrieves the data from the database
     */
    public function showFinalGrades()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $classId = Classroom::retrieveByClassCoordinator($teachId);

        $students = Student::retrieveStudentClass($classId);
        $subjects = Subject::retrieve();
        $finalGrades = FinalGrades::retrieveCurrentByClassId($classId);

        if ($finalGrades->count()) {
            // Final grades already stored for that class
            return view(FINAL_GRADES_SHOW,
                [CLASS_ID => $classId,
                    STUDENTS => $students,
                    SUBJECTS => $subjects,
                    FINAL_GRADES => $finalGrades
                ]);
        } else {
            // Final grades not yet stored for that class
            return view('finalgrades.insert')->with(['error' => 'Final grades not yet inserted!']);
        }
    }

    /*
     * This function is used by the class coordinator
     * It's used to download a template containing the names of students and of subjects
     * It retrieves students and subjects from the database, the class id from the route finalgrades/insert
     */
    public function downloadTemplate($classId)
    {
        $students = Student::retrieveStudentClass($classId);
        $subjects = Subject::retrieve();

        // Changing the current directory to the storage/app
        chdir('..');
        $actualpath = getcwd() . '/storage/app/';

        // Getting the full path of the file
        $filename = $classId . "_template.csv";
        $filepath = $actualpath . $filename;

        // Creating the data array, the header will contain 'Student' + the names of subjects
        $data = [];

        $header = ["Student Name", "StudentId"];
        foreach ($subjects as $subject) {
            array_push($header, $subject->subjectName);
        }

        array_push($data, $header);

        // For each student we save it's name and surname as an array, so data is an array of arrays
        foreach ($students as $student) {
            array_push($data, [$student->firstName . ' ' . $student->lastName,
                $student->id]);
        }

        // Open or create the requested file
        $fp = fopen($filepath, "w");

        // For each element of data, insert its content as a row in the csv file
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);

        // Setting the browser in order to download the file
        header("Content-type: text/csv");
        header("Content-disposition: attachment; filename = " . $filename);
        readfile($filepath);
    }

    /*
     * This function is used by the class coordinator
     * It's used to upload the template containing final grades
     * It retrieves the uploaded file from the route finalgrades/upload
     */
    public function uploadFinalGrades($classId, Request $request)
    {
        $file = $request->file('file');

        // Check the file encoding and BOM.

        $content = file_get_contents($file->path());

        $content = $this->remove_utf8_bom($content);
        file_put_contents($file->path(), $content);

        $csvHeaders = [];

        // Get header (StudentName, StudentId, Subject1, Subject2...)
        if (($handle = fopen($file->path(), "r")) !== FALSE) {

            $sep = ",";

            $csvHeaders = fgetcsv($handle, 1000, $sep);
        }

        $students_final_grades = [];

        // Get body
        // (StudentName1, StudentId1, Grade1, Grade2...)
        // (StudentName2, StudentId2, Grade1, Grade2...)
        // ...
        while (($row = fgetcsv($handle, 1000, $sep)) !== FALSE) {
            $students_final_grades[] = $row;
        }

        // Start the transaction, if there are errors all the operations will be rolled back
        DB::beginTransaction();

        foreach ($csvHeaders as $key => $subj) {
            // The first element of the csv header is "StudentName", we don't need it
            // The second element of the csv header is "StudentId", we don't need it
            if ($key > 1) {
                foreach ($students_final_grades as $row) {
                    $subject = $subj;

                    // The second element of each row is the student id
                    $data['idStudent'] = $row[1];
                    // Retrieve the id of the subject using the unique subjectName
                    $s = Subject::retrieveByName($subject);
                    $data['idSubject'] = $s->subjectId;
                    $data['year'] = date('Y');
                    $data[ID_CLASS] = $classId;

                    // If the finalgrade has been inserted, the operation goes on
                    if ($row[$key] != '') {
                        $data['finalgrade'] = $row[$key];
                    } else {
                        // If the finalgrade is not present, the operation aborts
                        DB::rollBack();
                        return redirect('/finalgrades/insert')->withErrors(['Error during upload!']);
                    }

                    // Insert the finalgrade row in the final_grades table
                    FinalGrades::save($data);
                }
            }
        }

        // If the foreach is ended, all operations finished without problems
        // We can commit the entire transaction
        DB::commit();

        return redirect(FINAL_GRADES_SHOW)->with([MESSAGE => SUCCESS]);
    }

    function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
