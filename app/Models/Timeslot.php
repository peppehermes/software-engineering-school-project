<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Timeslot
{
    const table = 'timeslots';
    const first = '8:00';
    const second = '9:00';
    const third = '10:00';
    const forth = '11:00';
    const fifth = '12:00';
    const sixth = '13:00';


    public static function retrieveTimeslot($day,$hour)
    {
        return DB::table(static::table)
            ->where('day', $day)
            ->where('hour',$hour)
            ->value('id');

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
