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
     * Retrieve company by id
     *
     * @param int $id
     * @return mixed
     */
    public static function retrieveById(int $id)
    {

        return DB::table(static::table)->find($id);
    }

    public static function retrieveByNameSubject($name,$subject)
    {

        return DB::table(static::table)
            ->select('id')
            ->join('teaching','teacher.id','=','teaching.idTeach')
            ->whereRaw('CONCAT(firstName, " ",lastName) LIKE ? ', array('%' . $name . '%'))
            ->where('subject',$subject)
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
            ->join('classroom', 'teaching.idClass', '=', 'classroom.id')
            ->where('teaching.idTeach', $id)
            ->get();

    }


}
