<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class FinalGrades
{
    const table = 'final_grades';

    /**
     * Retrieve the list of all finalgrades
     *
     * @return \Illuminate\Support\Collection
     */
    public static function retrieve(): Collection
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.idStudent','DESC')
            ->get();
    }

    /**
     * Retrieve finalgrade by id
     *
     * @param int $id
     * @return mixed
     */
    public static function retrieveById(int $id)
    {
        return DB::table(static::table)->find($id);
    }

    /**
     * Retrieve current finalgrade by classId
     *
     * @param int $idClass
     * @return mixed
     */
    public static function retrieveCurrentByClassId($idClass): Collection
    {
        $params = ['idClass' => $idClass,
        'year' => date('Y')];

        return DB::table('final_grades')
            ->select('final_grades.*')
            ->where($params)
            ->get();
    }

    /**
     * Retrieve past finalgrade by classId and year
     *
     * @param int $idClass
     * @param int $year (the year when the academic year started)
     * @return mixed
     */
    public static function retrievePastByClassId($idClass, $year)
    {
        $params = ['idClass' => $idClass,
            'year' => $year];
        return DB::table(static::table)->where($params);
    }

    /**
     * Insert finalgrade into the final_grades table
     *
     * @param array $data
     * @return mixed
     *
     * The array $data must contain int idStudent, int idSubject, int year, string idClass, int finalgrade
     */
    public static function save(array $data)
    {
        \DB::table(static::table)->insert($data);
    }

    /**
     * Delete a single finalgrade by its idStudent, idSubject, year
     *
     * @param int $idStudent
     * @param int $idSubject
     * @param int $year
     * @return mixed
     */
    public static function delete(int $idStudent, int $idSubject, int $year): int
    {
        $params = ['idStudent' => $idStudent,
            'idSubject' => $idSubject,
            'year' => $year];
        return DB::table(static::table)->where($params)->delete();
    }

    /**
     * Delete current finalgrade by classId
     *
     * @param int $idClass
     * @return mixed
     */
    public static function deleteCurrentForClass($idClass): int
    {
        $params = ['idClass' => $idClass,
            'year' => date('Y')];
        return DB::table(static::table)->where($params)->delete();
    }

    /**
     * Delete past finalgrade by classId and year
     *
     * @param int $idClass
     * @param int $year (the year when the academic year started)
     * @return mixed
     */
    public static function deletePastForClass($idClass, $year): int
    {
        $params = ['idClass' => $idClass,
            'year' => $year];
        return DB::table(static::table)->where($params)->delete();
    }
}
