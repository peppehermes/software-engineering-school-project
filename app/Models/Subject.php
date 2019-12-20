<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Subject
{
    const table = 'subjects';

    /**
     * Retrieve the list of all subjects
     *
     * @return \Illuminate\Support\Collection
     */
    public static function retrieve(): Collection
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.subjectId','DESC')
            ->get();
    }

    /**
     * Retrieve subject by id
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
            \DB::table(static::table)->where('subjectId', $id)->update($data);

            return $id;
        }

        return \DB::table(static::table)->insertGetId($data);
    }

    public static function delete(int $id): int
    {
        return DB::table(static::table)->where('subjectId', $id)->delete();
    }


    public static function retrieveSubjectsForClass($classID)
    {
        return DB::table('teaching')
            ->where('idClass', $classID)
            ->get();

    }


    public static function retrieveTotHoursForSubject($teachingID)
    {
        $result = DB::table('subject_programming')
            ->where('idTeaching', $teachingID)
            ->first();

        return $result->totalHours;

    }



}
