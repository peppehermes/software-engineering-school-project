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
            ->orderBy(static::table . '.id', 'DESC')
            ->get();

    }


    public static function retrieveStudentsForParent($myParentID)
    {

        return DB::table('student')
            ->select('student.*')
            ->join('studForParent', 'student.id', '=', 'studForParent.idStudent')
            ->join('users', 'users.id', '=', 'studForParent.idParent')
            ->where('studForParent.idParent', $myParentID)
            ->get();


    }


    public static function retrieveMarksForStudent($myStudentID)
    {


        return DB::table('marks')
            ->select('marks.*', 'teacher.firstName as teachFirstName', 'teacher.lastName as teachLastName')
            ->join('teacher', 'teacher.id', '=', 'marks.idTeach')
            ->where('marks.idStudent', $myStudentID)
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

}
