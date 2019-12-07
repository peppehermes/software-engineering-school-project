<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Meeting
{

    const table = 'meetings';

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

    public static function delete_per_teacher( $id, $idt,$week): int
    {
        return DB::table(static::table)->where('idTimeslot', $id)->where('idTeacher',$idt)->where('idweek', $week)->delete();
    }

    public static function retrieveWeeklyMeetingperTeacher($id,$week)
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('idTeacher', $id)
            ->where('idweek', $week)
            ->get();

    }

    public static function retrieveMeetingperTeacher($id)
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('idTeacher', $id)
            ->get();

    }

    public static function retrieve(): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.id', 'ASC')
            ->get();

    }
}
