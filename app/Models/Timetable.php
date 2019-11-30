<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Timetable
{
    const table = 'timetable';

    public static function save(array $data): int
    {
        return \DB::table(static::table)->insertGetId($data);
    }
    public static function retrieveTimeslotClass($timeslot,$class)
    {
        return DB::table(static::table)
            ->where('idTimeslot', $timeslot)
            ->where('idClass',$class)
            ->get();

    }

    public static function retrieveTimeslotData($class)
    {
        return DB::table(static::table)
            ->join('timeslots',static::table.'.idTimeslot','=','timeslots.id')
            ->where('idClass',$class)
            ->orderBy('idTimeslot')
            ->get();

    }


}
