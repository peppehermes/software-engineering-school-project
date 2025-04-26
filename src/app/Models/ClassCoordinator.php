<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class ClassCoordinator
{
    const table = 'class_coordinator';

    /**
     * Retrieve the list of all class coordinators
     *
     * @return \Illuminate\Support\Collection
     */
    public static function retrieve(): Collection
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.idTeach','DESC')
            ->get();
    }

    /**
     * Retrieve row by teacher id
     *
     * @param int $idTeach
     * @return int idClass
     */
    public static function retrieveByTeachId(int $idTeach): int
    {
        return DB::table(static::table)
            ->select([
                static::table . '.idClass'
            ])
            ->where('idTeach', $idTeach)
            ->value('idClass');
    }

    /**
     * Retrieve row by class id
     *
     * @param string $idClass
     * @return int idTeach
     */
    public static function retrieveByClassId($idClass)
    {
        return DB::table(static::table)
            ->select([
                static::table . '.idTeach'
            ])
            ->where('idClass', $idClass)
            ->value('idTeach');
    }

    /**
     * Insert or update row using teacher id
     *
     * @param array $data
     * @param $idTeach
     * @return mixed
     */
    public static function save(array $data, $idTeach = null): int
    {
        if ($idTeach) {
            \DB::table(static::table)->where('idTeach', $idTeach)->update($data);

            return $idTeach;
        }

        return \DB::table(static::table)->insertGetId($data);
    }

    /**
     * Delete row using teacher id
     *
     * @param $idTeach
     * @return mixed
     */
    public static function delete(int $idTeach): int
    {
        return DB::table(static::table)->where('idTeach', $idTeach)->delete();
    }

    /**
     * Retrieve teachers teaching in a class that are not class coordinator using class id
     *
     * @param $idClass
     * @return mixed
     */
    public static function retrieveNonCoordinatorTeachers($idClass): Collection
    {
        $coordinatorsId = DB::table('class_coordinator')
            ->pluck('idTeach');

        return DB::table('teaching')
            ->join('teacher', 'teacher.id', '=', 'teaching.idTeach')
            ->select('teaching.idTeach', 'teacher.firstName', 'teacher.lastName')
            ->whereNotIn('teaching.idTeach', $coordinatorsId)
            ->where('teaching.idClass', $idClass)
            ->orderBy('teaching.idTeach', 'DESC')
            ->distinct()
            ->get();
    }
}
