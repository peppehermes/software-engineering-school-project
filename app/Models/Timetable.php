<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Timetable
{
    const table = 'timetable';

    public static function save(array $data): int
    {
        //constraint for controlling a teacher can have just one subject in each timeslot
        $res=DB::table(static::table)
            ->where('idTimeslot', $data['idTimeslot'])
            ->where('idTeacher', $data['idTeacher'])
            ->get();
        if(count($res)==0){
            return \DB::table(static::table)->insertGetId($data);
        }
        return 0;

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
            ->join('timeslots', static::table.'.idTimeslot', '=', 'timeslots.id')
            ->where('idClass', $class)
            ->orderBy('idTimeslot')
            ->get();

    }


    public static function saveManual($classID, $timeslotID, $teacherID, $subject)
    {

        DB::table('timetable')
            ->updateOrInsert(
                ['idClass' => $classID, 'idTimeslot' => $timeslotID],
                ['idTeacher' => $teacherID, 'subject' => $subject]
            );


    }

    public static function saveManualFreeHour($classID, $timeslotID)
    {

        DB::table('timetable')
            ->updateOrInsert(
                ['idClass' => $classID, 'idTimeslot' => $timeslotID],
                ['idTeacher' => 0, 'subject' => "Free"]
            );


    }



    public static function checkTimetableConstraint($classID, $timeslotID, $teacherID)
    {

        return DB::table(static::table)
            ->where('idTimeslot', $timeslotID)
            ->where('idTeacher', $teacherID)
            ->where('idClass', '!=',  $classID)
            ->get();


    }


}
