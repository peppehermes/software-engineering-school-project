<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Mark
{
    const table = 'marks';

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

    public static function retrieveTeachersPagination(int $id)
    {
        return  DB::table(static::table)
            ->join('teacher', 'marks.idTeach', '=', 'teacher.id')
            ->join('student', 'marks.idStudent', '=', 'student.id')
            ->select(static::table . '.*','teacher.*','student.firstName as studentName', 'student.lastName as studentSurname')
            ->where('teacher.id', $id)
            ->orderby('date', 'desc')
            ->paginate(10);

    }

    public static function retrieveTeachersSubjectTopic(int $id,string $subject,string $topic,string $date,int $idStudent)
    {
        return  DB::table(static::table)
            ->select(static::table.'.id',static::table.'.mark')
            ->join('teacher', 'marks.idTeach', '=', 'teacher.id')
            ->join('student', 'marks.idStudent', '=', 'student.id')
            ->where('teacher.id', $id)
            ->where('subject', $subject)
            ->where('topic', $topic)
            ->where('date', $date)
            ->where('idStudent', $idStudent)
            ->orderby('date', 'desc')
            ->first();

    }

    public static function retrieveTeachersClasses(int $id, string $idClass)
    {
        return  DB::table(static::table)
            ->select(static::table . '.*','teacher.*','student.firstName as studentName', 'student.lastName as studentSurname')
            ->join('teacher', 'marks.idTeach', '=', 'teacher.id')
            ->join('student', 'marks.idStudent', '=', 'student.id')
            ->where('teacher.id', $id)
            ->where(static::table.'.idClass', $idClass)
            ->orderby('date', 'desc')
            ->paginate(10);

    }




}

