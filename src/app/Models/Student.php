<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Student
{
    const table = 'student';

    /**
     * Retrieve the list of all students
     *
     * @return \Illuminate\Support\Collection
     */
    public static function retrieve(): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.id', 'DESC')
            ->get();

    }

    /**
     * Retrieve company by id
     *
     * @param int $id
     * @return mixed
     */
    public static function retrieveById(int $id)
    {

        return DB::table(static::table)->find($id);

    }

    public static function retrieveStudentById($id): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('id', $id)
            ->get();

    }


    public static function retrieveStudentsByCondition($array)
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where($array)
            ->get();

    }

    public static function retrieveAvgSkillStudents($array)
    {

        return DB::table(static::table)
            ->where($array)
            ->avg('skill');

    }




    public static function save(array $data, $id = null): int
    {
        if ($id) {
            \DB::table(static::table)->where('id', $id)->update($data);

            return $id;
        }

        return \DB::table(static::table)->insertGetId($data);
    }

    public static function delete(int $id): int
    {
        return DB::table(static::table)->where('id', $id)->delete();
    }

    public static function retrieveStudentWithoutClass(): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('classId', NULL)->orWhere('classId', '')
            ->orderBy(static::table . '.id', 'DESC')
            ->get();

    }

    public static function retrieveStudentClass($id): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('classId', $id)
            ->orderBy(static::table . '.lastName', 'ASC')
            ->get();

    }


    public static function retrieveStudentsForParent($myParentID)
    {

        return DB::table('student')
            ->select('student.*', 'student.id as studentId')
            ->join('studforparent', 'student.id', '=', 'studforparent.idStudent')
            ->join('users', 'users.id', '=', 'studforparent.idParent')
            ->where('studforparent.idParent', $myParentID)
            ->get();


    }

    public static function retrieveStudentsForTeacher($teacherId)
    {

        return DB::table('student')
            ->selectRaw('distinct student.*')
            ->join('teaching', 'student.classId', '=', 'teaching.idClass')
            ->where('teaching.idTeach', $teacherId)
            ->get();


    }


    public static function retrieveMarksForStudent($myStudentID)
    {


        return DB::table('marks')
            ->select('marks.*', 'teacher.firstName as teachFirstName', 'teacher.lastName as teachLastName')
            ->join('teacher', 'teacher.id', '=', 'marks.idTeach')
            ->where('marks.idStudent', $myStudentID)
            ->orderby('marks.date', 'asc')
            ->get();

    }

    //retrieve all the subjects that the student attends to
    public static function retrieveSubjectsForStudent($myStudentID)
    {


        return DB::table('teaching')
            ->select('teaching.*')
            ->join('student', 'teaching.idClass', '=', 'student.classId')
            ->where('student.id', $myStudentID)
            ->get();

    }


    //retrieve all the average of that subject's marks for that student
    public static function retrieveAverageForStudent($myStudentID)
    {


        return DB::table('marks')
            ->select(DB::raw('avg(marks.mark) as avg_mark, marks.subject'))
            ->where('marks.idStudent', $myStudentID)
            ->groupBy('marks.subject')
            ->get();

    }





    public static function retrievePagination($page)
    {
        return DB::table(static::table)->orderby('id', 'desc')->paginate($page);

    }

    public static function retrieveClassId($id)
    {

        return DB::table(static::table)
            ->where('id', $id)
            ->value('classId');

    }

    public static function saveStudParent(array $data, $id = null): int
    {
        if ($id) {
            \DB::table('studforparent')->where('id', $id)->update($data);

            return $id;
        }

        return \DB::table('studforparent')->insertGetId($data);
    }

    public static function deleteParentStudent($idParent, $idstudent): int
    {
        return DB::table('studforparent')->where('idParent', $idParent)->where('idStudent', $idstudent)->delete();
    }

    public static function saveStudentAttendance(array $data, $studentId = null, $teacherId = null, $classId = null, $lectureDate = null): int
    {
        if ($studentId && $teacherId && $classId && $lectureDate) {
            \DB::table('student_attendance')->where('studentId', $studentId)->where('teacherId', $teacherId)->where('classId', $classId)->where('lectureDate', $lectureDate)->update($data);

            return $studentId;
        }

        return \DB::table('student_attendance')->insertGetId($data);
    }

//for all students
    public static function retrieveStudentsAttendance($studentId = null, $teacherId = null, $classId = null, $lectureDate = null)
    {
        $res = DB::table('student')
            ->select('student.*', 'student_attendance.status', 'student_attendance.presence_status', 'student_attendance.description', 'student_attendance.status')
            ->join('student_attendance', 'student.id', '=', 'student_attendance.studentId');

        if ($studentId) {
            $res->where('studentId', $studentId);
        }
        if ($teacherId) {
            $res->where('teacherId', $teacherId);
        }
        if ($classId) {
            $res->where('student.classId', $classId);
        }
        if ($lectureDate) {
            $res->where('lectureDate', $lectureDate);
        }


        return $res->get();

    }

//just for one student
    public static function retrieveStudentAttendance($studentId = null, $teacherId = null, $classId = null, $lectureDate = null)
    {
        $res = DB::table('student')
            ->select('student_attendance.status', 'student_attendance.presence_status', 'student_attendance.description', 'student_attendance.status')
            ->join('student_attendance', 'student.id', '=', 'student_attendance.studentId');

        if ($studentId) {
            $res->where('studentId', $studentId);
        }
        if ($teacherId) {
            $res->where('teacherId', $teacherId);
        }
        if ($classId) {
            $res->where('student.classId', $classId);
        }
        if ($lectureDate) {
            $res->where('lectureDate', $lectureDate);
        }


        return $res->first();

    }

    public static function retrieveAttendance($studentId = null, $teacherId = null, $classId = null, $lectureDate = null)
    {
        $res = DB::table('student_attendance');

        if ($studentId) {
            $res->where('studentId', $studentId);
        }
        if ($teacherId) {
            $res->where('teacherId', $teacherId);
        }
        if ($classId) {
            $res->where('classId', $classId);
        }
        if ($lectureDate) {
            $res->where('lectureDate', $lectureDate);
        }


        return $res->first();

    }

    public static function retrieveAttendanceReport($studentId = null, $teacherId = null, $classId = null, $lectureDate = null)
    {
        $res = DB::table('student_attendance')
        ->select('student.id','student.firstName','student.lastName','student_attendance.status', 'student_attendance.presence_status', 'student_attendance.description', 'student_attendance.status', 'student_attendance.lectureDate')
        ->join('student', 'student.id', '=', 'student_attendance.studentId');


        if ($studentId) {
            $res->where('studentId', $studentId);
        }
        if ($teacherId) {
            $res->where('teacherId', $teacherId);
        }
        if ($classId) {
            $res->where('classId', $classId);
        }
        if ($lectureDate) {
            $res->where('lectureDate', $lectureDate);
        }
        $res->orderBy('lectureDate','DESC');



        return $res->paginate(10);

    }

    public static function convertDate($date)
    {
        $newdate=explode('/',$date);
        return implode('-',[$newdate[2],$newdate[1],$newdate[0]]);
    }

    public static function convertDateView($date)
    {
        $newdate=explode('-',$date);
        return implode('/',[$newdate[2],$newdate[1],$newdate[0]]);
    }


}
