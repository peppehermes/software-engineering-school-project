<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Teachers;
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
        $classes = Classroom::retrieve();
        return view('teacher.add', ['classes' => $classes]);
    }

    public function store(Request $request)
    {


        $data = request('frm');
        $dataT = request('frmT');

        if ($data) {
            //create user
            $userData['email'] = strtolower(request('email'));
            $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];
            $userData['roleId'] = Role::retrieveByRole('Teacher');

            $password = $this->password_generate(8);
            $userData['password'] = Hash::make($password);
            $userId = User::saveUser($userData);

            if ($data['birthday']) {
                $data['birthday'] = Student::convertDate($data['birthday']);
            }


            $data['userId'] = $userId;

            if ($request->file('photo')) {

                $cover = $request->file('photo');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['photo'] = $fileName;
            }

            $Teachid = Teacher::save($data);

            if (strpos($dataT['subject'], '-')) {
                $subjects = explode('-', $dataT['subject']);
                foreach ($subjects as $subject) {
                    $dataT['idTeach'] = $Teachid;
                    $dataT['subject'] = $subject;

                    Teacher::saveTeaching($dataT);
                }
            } else {
                $dataT['idTeach'] = $Teachid;
                Teacher::saveTeaching($dataT);
            }


        }


        //send email
        $to_name = $userData['name'];
        $to_email = $userData['email'];
        $data = array('name' => $to_name, 'password' => $password);
        \Mail::send('email.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Teacher Password');
            $message->from('sahar.saadatmandii@gmail.com', 'Password');
        });


        return redirect('/teacher/list')->with(['message' => 'Successful operation!']);

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
            $teacherInfo->idClass =$teaching->idClass ;
        }
        $teacherInfo->subject = implode('-', $subjects);



        return view('teacher.edit', ['teacherInfo' => $teacherInfo,'classes'=>$classes]);
    }

    public function update
    (Request $request, $id)
    {

        $teacher = Teacher::retrieveById($id);

        $data = request('frm');
        $dataT = request('frmT');

        if ($data['birthday']) {
            $data['birthday'] = Student::convertDate($data['birthday']);
        }
        $userData['email'] = strtolower(request('email'));
        $userData['name'] = $data['firstName'] . ' ' . $data['lastName'];


        User::saveUser($userData, $teacher->userId);


        if ($request->file('photo')) {

            $cover = $request->file('photo');

            $extension = $cover->getClientOriginalExtension();
            $fileName = date('YmdHis') . '.' . $extension;
            \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


            $data['photo'] = $fileName;
        }
        Teacher::save($data, $id);

        if (strpos($dataT['subject'], '-')) {
            $subjects = explode('-', $dataT['subject']);
            Teacher::deleteTeaching($id,$dataT['idClass']);
            foreach ($subjects as $subject) {
                $dataT['idTeach'] = $id;
                $dataT['subject'] = $subject;

                Teacher::saveTeaching($dataT);
            }
        } else {
            $dataT['idTeach'] = $id;
            Teacher::deleteTeaching($id,$dataT['idClass']);
            Teacher::saveTeaching($dataT);
        }


        return redirect('/teacher/list')->with(['message' => 'Successful operation!']);

    }

    public function delete($id)
    {

        $teacherInfo = Teacher::retrieveById($id);
        Teacher::delete($id);
        User::deleteById($teacherInfo->userId);


        return redirect('/teacher/list')->with(['message' => 'successful operation!']);

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
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Topic::save($data);
        }
        return redirect('/topic/list')->with(['message' => 'Successful operation!']);
    }

    public function addtopic()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('topic.add', ['classes' => $classes, 'subjects' => $subjects, 'date' => $dateview]);
    }

    public function storeassignment(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            $data['deadline'] = request('deadline');
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['deadline'] = Student::convertDate($data['deadline']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = Teacher::retrieveId($usId);
            if ($request->file('attachment')) {

                $cover = $request->file('attachment');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['attachment'] = $fileName;
            }
            Assignment::save($data);
        }
        return redirect('/assignment/list')->with(['message' => 'successful operation!']);


    }


    public function addassignment()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $subjects = Teacher::retrieveTeaching($teachId);
        return view('assignments.add', ['classes' => $classes, 'subjects' => $subjects, 'date' => $dateview]);
    }


    public function listassignment()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $assignments = Assignment::retrieveTeachersPagination($teachId);
        return view('assignments.list', ['assignments' => $assignments]);
    }

    public function storemark(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');
        if ($data) {
            //create topic
            $data['date'] = request('lecturedate');
            $data['date'] = Student::convertDate($data['date']);
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['mark'] = request('mark');
            $data['idStudent'] = request('idStudent');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');
            Mark::save($data);
        }
        return redirect('/mark/list')->with(['message' => 'Successful operation!']);


    }

    public function addnewmark(Request $request)
    {


        $usId = \Auth::user()->id;

        $classRooms = Teacher::retrieveTeacherClass($usId);

        $students = Student::retrieveStudentClass(request('idClass'));

        $classId = request('idClass');
        $date = request('lecturedate');
        $subject = request('subject');
        $topic = request('topic');
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


        return view('marks.addnewmark', ['students' => $students, 'classRooms' => $classRooms, 'classId' => $classId, 'date' => $date, 'subject' => $subject, 'topic' => $topic, 'classes' => $classes, 'subjects' => $subjects, 'subjectsClass' => $subjectsClass]);


    }

    public function storenewmark(Request $request)
    {

        $usId = \Auth::user()->id;
        $students = Student::retrieveStudentClass(request('classId'));


        foreach ($students as $student) {

            $data = request('frm' . $student->id);
            $data2 = request('frm2' . $student->id);


            if ($data && isset($data['mark']) && isset($data2['status'])) {
                $data['subject'] = request('subject');
                $data['topic'] = request('topic');
                $data['idClass'] = request('classId');

                $data['date'] = request('date');
                $data['date'] = Student::convertDate($data['date']);
                $data['idTeach'] = Teacher::retrieveId($usId);

                $mark = Mark::retrieveTeachersSubjectTopic($data['idTeach'], $data['subject'], $data['topic'], $data['date'], $student->id);;

                if ($mark) {
                    Mark::save($data, $mark->id);
                } else {
                    Mark::save($data);
                }


            }
        }
        return redirect('/mark/classlist')->with(['message' => 'Successful operation!']);


    }

    public function listclasses()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.classes', ['classes' => $classes, 'studId' => $studId, 'subjects' => $subjects, 'date' => $dateview]);
    }


    public function addmark()
    {
        $usId = \Auth::user()->id;
        $date = date("Y-m-d");
        $dateview = Student::convertDateView($date);
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('marks.add', ['classes' => $classes, 'studId' => $studId, 'subjects' => $subjects, 'date' => $dateview]);
    }


    public function listmark()
    {
        $usId = \Auth::user()->id;
        $classId = request('classId');
        $teachId = Teacher::retrieveId($usId);
        $marks = Mark::retrieveTeachersClasses($teachId, $classId);
        return view('marks.list', ['marks' => $marks, 'classId' => $classId]);
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
        return view('suppmaterial.add', ['classes' => $classes, 'subjects' => $subjects]);
    }

    public function storematerial(Request $request)
    {

        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create topic
            $data['date'] = date("Y-m-d");
            $data['idClass'] = request('idClass');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');

            if ($request->file('material')) {

                $cover = $request->file('material');

                $extension = $cover->getClientOriginalExtension();
                $fileName = date('YmdHis') . '.' . $extension;
                \Storage::disk('public_uploads')->put($fileName, \File::get($cover));


                $data['material'] = $fileName;
            }

            Material::save($data);
        }
        return redirect('/material/list')->with(['message' => 'Successful operation!']);
    }

    public function listmaterial()
    {
        $usId = \Auth::user()->id;

        $teachId = Teacher::retrieveId($usId);
        $materials = Material::retrieveTeachersPagination($teachId);
        return view('suppmaterial.list', ['materials' => $materials]);
    }

    public function writenote()
    {
        $usId = \Auth::user()->id;
        $teachId = Teacher::retrieveId($usId);
        $subjects = Teacher::retrieveTeaching($teachId);
        $classes = Teacher::retrievedistinctTeaching($teachId);
        $studId = Student::retrieveStudentsForTeacher($teachId);
        return view('notes.write', ['classes' => $classes, 'stud' => $studId, 'subjects' => $subjects]);
    }

    public function storenote(Request $request)
    {
        $usId = \Auth::user()->id;
        $data = request('frm');

        if ($data) {
            //create note
            $data['date'] = date("Y-m-d");
            $data['idClass'] = request('idClass');
            $data['idStudent'] = request('idStudent');
            $data['subject'] = request('subject');
            $data['idTeach'] = DB::table('teacher')->where('userId', $usId)->value('id');

            Note::save($data);
        }
        return redirect('/notes/list')->with(['message' => 'Successful operation!']);
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
        if (count($exist) == 0)

            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . ' ' . $teach->lastName . ' first provide the two timeslots.']);

        else {
            $times = Timeslot::retrieve();
            $bool = 1;
            $provided = Meeting::retrieveWeeklyMeetingperTeacher($teachId, $week);// already provided timeslots
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);

            if (count($timeslots) > 0) {


                return view('meetings.list', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool, 'provided' => $provided, 'week' => $week, 'date1' => $date1, 'date2' => $date2]);

            } else
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);

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

        if (count($provided) > 0)
            return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . ' ' . $teach->lastName . ' has already provided the two timeslots']);

        else {
            foreach ($times as $time) {
                $data[$time->hour][] = $time->id;
            }
            $timeslots = Teacher::retrieveTimeslots($teachId);
            if (count($timeslots) > 0) {


                return view('meetings.add', ['timeslots' => $timeslots, 'times' => $data, 'teach' => $teach, 'bool' => $bool,]);

            } else
                return \Redirect('/')->withErrors([' Teacher ' . $teach->firstName . $teach->lastName . ' is not assigned to any class yet.']);

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

            $message = 'Too many timeslots provided, please provide at most 3!';
            return $message;
        } else {
            $data['idTeacher'] = $teachId;
            $data['idweek'] = $week;

            foreach ($slots as $d) {
                $data['idTimeslot'] = $d;
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
                $data['idweek'] = ($year . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
            // between january and end of the school in june
            for ($i = 2; $i < 29; $i++) {
                if ($i < 10)
                    $data['idweek'] = $year + 1 . '-W' . '0' . $i;
                else
                    $data['idweek'] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
        } // if we are after January
        else if ($week > 1 && $week < 28) {
            for ($i = $week; $i < 29; $i++) {
                if ($i < 10)
                    $data['idweek'] = $year + 1 . '-W' . '0' . $i;
                else
                    $data['idweek'] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
                    Meeting::save($data);
                }
            }
        } // we are in the first week of january
        else if ($week == 1) {
            for ($i = $week + 1; $i < 29; $i++) {
                if ($i < 10)
                    $data['idweek'] = $year + 1 . '-W' . '0' . $i;
                else
                    $data['idweek'] = ($year + 1 . '-W' . $i);
                foreach ($slots as $d) {
                    $data['idTimeslot'] = $d;
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
            return view('/finalgrades/show', ['classId' => $classId,
                'students' => $students,
                'subjects' => $subjects,
                'finalgrades' => $finalGrades
            ])->with(['message' => 'Final grades already stored!']);
        } else {
            // Final grades not yet stored for that class
            return view('finalgrades.insert',
                ['classId' => $classId,
                    'students' => $students,
                    'subjects' => $subjects
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
            return view('/finalgrades/show', ['classId' => $classId,
                'students' => $students,
                'subjects' => $subjects,
                'finalgrades' => $finalGrades
            ])->with(['message' => 'Final grades already stored!']);
        } else {
            // Final grades not yet stored for that class
            foreach ($students as $student) {
                foreach ($subjects as $subject) {
                    // The key of the request is made by the id of the student and the id of the subject
                    $data = request('frm' . $student->id . $subject->subjectId);

                    // Insert year and data into the data array
                    $data['year'] = date('Y');
                    $data['idClass'] = $classId;

                    // Insert into finalgrades table
                    FinalGrades::save($data);
                }
            }
        }

        return redirect('/finalgrades/show')->with(['message' => 'successful operation!']);
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
            return view('/finalgrades/show',
                ['classId' => $classId,
                    'students' => $students,
                    'subjects' => $subjects,
                    'finalgrades' => $finalGrades
                ]);
        } else {
            // Final grades not yet stored for that class
            return view('finalgrades.insert')->with(['error' => 'Final grades not yet inserted!']);
        }
    }
}
