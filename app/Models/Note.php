<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Note
{
    const table = 'notes';

    /**
     * Retrieve the list of all notes
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
     * Retrieve notes by id
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

    // Used by teacher to read notes they have sent
    public static function retrieveTeachersPagination(int $id)
    {
        return  DB::table(static::table)
            ->join('teacher', 'notes.idTeach', '=', 'teacher.id')
            ->join('student', 'notes.idStudent', '=', 'student.id')
            ->select(static::table . '.*','teacher.*','student.firstName as studentName', 'student.lastName as studentSurname')
            ->where('teacher.id', $id)
            ->orderby('date', 'desc')
            ->paginate(10);
    }

    // Used to let parents read notes
    public static function getMaterialByClass($idClass)
    {
        return DB::table(static::table)
            ->select('suppmaterial.*', 'teacher.firstName as firstName', 'teacher.lastName as lastName')
            ->join('teacher', 'suppmaterial.idTeach', '=', 'teacher.id')
            ->where('idClass', $idClass)
            ->get();

    }


}
