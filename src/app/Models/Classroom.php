<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Classroom
{
    const table = 'classroom';

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
            ->orderBy(static::table . '.id','DESC')
            ->get();

    }


    /**
     * Retrieve company by id
     *
     * @param int $id
     * @return mixed
     */
    public static function retrieveById( $id)
    {

        return DB::table(static::table)->find($id);
    }


    public static function save(array $data, $id = null): string
    {
        if ($id) {
            \DB::table(static::table)->where('id', $id)->update($data);

            return $id;
        }

        return \DB::table(static::table)->insertGetId($data);
    }

    public static function delete(string $id): int
    {
        return DB::table(static::table)->where('id', $id)->delete();
    }

    public static function retrieveClass(string $id)
    {

        return DB::table(static::table)->find($id);
    }

    public static function retrieveAll()
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.id','DESC')
            ->paginate(20);

    }

    public static function retrieveByStudentId($id)
    {

        return DB::table('classroom')
            ->select('classroom.id')
            ->join('student', 'classroom.id', '=', 'student.classId')
            ->where('student.id', $id)
            ->value('id');

    }

    /*
     *  This function, given a teacher id, returns the class he's coordinator of, if any
     *  It's used by the TeacherController to pass this class to the view
     */
    public static function retrieveByClassCoordinator($idTeach)
    {
        return DB::table('classroom')
            ->select('classroom.id')
            ->join('class_coordinator', 'classroom.id', '=', 'class_coordinator.idClass')
            ->where('class_coordinator.idTeach', $idTeach)
            ->value('idClass');
    }
}
