<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Teacher
{
    const table = 'teacher';

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
     * Retrieve teacher row by id
     *
     * @param int $id
     * @return mixed
     */
    public static function retrieveById(int $id)
    {
        return DB::table(static::table)->find($id);
    }

    public static function retrieveByNameSubject($name, $subject)
    {

        return DB::table(static::table)
            ->select('teacher.id')
            ->join('teaching','teacher.id','=','teaching.idTeach')
            ->whereRaw('CONCAT(firstName, " ",lastName) LIKE ? ', array('%' . $name . '%'))
            ->where('subject', $subject)
            ->value('id');
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

    public static function deleteTeaching(int $id,string $idClass): int
    {
        return DB::table('teaching')->where('idTeach', $id)->where('idClass', $idClass)->delete();
    }
    public static function deleteTeachingTeacherId(int $id): int
    {
        return DB::table('teaching')->where('idTeach', $id)->delete();
    }
    public static function retrieveId(int $id)
    {
        return DB::table(static::table)
            ->where('userId', $id)
            ->value('id');

    }

    public static function retrieveTeaching(int $id)
    {
        return DB::table('teaching')
            ->select('teaching.*')
            ->where('idTeach', $id)
            ->get();

    }

    public static function retrieveTeachingClass(int $id,string $classId)
    {
        return DB::table('teaching')
            ->select('teaching.*')
            ->where('idTeach', $id)
            ->where('idClass', $classId)
            ->get();

    }

    public static function retrievedistinctTeaching(int $id)
    {
        return DB::table('teaching')
            ->selectRaw('distinct teaching.idClass')
            ->where('idTeach', $id)
            ->get();

    }

    public static function retrievePagination($page)
    {
        return DB::table(static::table)->orderby('id', 'desc')->paginate($page);

    }

    public static function saveTeaching(array $data, $id = null): int
    {
        if ($id) {
            \DB::table('teaching')->where('id', $id)->update($data);

            return $id;
        }

        return \DB::table('teaching')->insertGetId($data);
    }

    public static function retrieveTeacherClass($id): Collection
    {

        return DB::table('teaching')
            ->select('teaching.idClass', 'classroom.capacity', 'classroom.description')
            ->distinct()
            ->join('classroom', 'teaching.idClass', '=', 'classroom.id')
            ->where('teaching.idTeach', $id)
            ->get();

    }


    public static function retrieveTeacherOnlyClasses($id): Collection
    {

        return DB::table('teaching')
            ->selectRaw('distinct classroom.*')
            ->join('teacher', 'teaching.idTeach', '=', 'teacher.id')
            ->join('classroom', 'teaching.idClass', '=', 'classroom.id')
            ->where('teacher.userId', $id)
            ->get();

    }

    public static function retrieveTimeslots($id): Collection
    {

        return DB::table('timetable')
            ->select('timeslots.*','timetable.subject', 'timetable.idClass')
            ->join('timeslots', 'timetable.idTimeslot', '=', 'timeslots.id')
            ->where('timetable.idTeacher', $id)
            ->get();

    }


    public static function retrieveTeachersForStudent($id): Collection
    {

        return DB::table('teacher')
            ->selectRaw('distinct teacher.*')
            ->join('teaching', 'teacher.id', '=', 'teaching.idTeach')
            ->join('classroom', 'teaching.idClass', '=', 'classroom.id')
            ->join('student', 'student.classId', '=', 'classroom.id')
            ->where('student.id', $id)
            ->get();

    }
}
