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
                static::table . '.*','student.*','users.*'
            ])
            ->leftjoin('student', static::table.'.idStud', '=', 'student.id')
            ->leftjoin('users', static::table.'.idParent', '=', 'users.id')
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

    //retrieves all meetings for that Parent, with also info on the student
    public static function retrieveMeetingperParent($id)
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*', 'student.firstName as studFirstName', 'student.lastName as studLastName',
                                'teacher.firstName as teachFirstName', 'teacher.lastName as teachLastName',
                                'timeslots.day', 'timeslots.hour'
            ])
            ->join('student', static::table.'.idStud', '=', 'student.id')
            ->join('timeslots', static::table.'.idTimeslot', '=', 'timeslots.id')
            ->join('teacher', static::table.'.idTeacher', '=', 'teacher.id')
            ->where('isBooked', 1)
            ->where('idParent', $id)
            ->get();

    }



    // Retrieves all meetings with that teacher for that parent
    public static function retrieveMeetingTeachForParents($idTeach,$idParent)
    {
        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->where('idTeacher', $idTeach)
            ->where('idParent', $idParent)
            ->get();

    }

    // Book the meeting
    public static function updateMeetingStatus(array $data)
    {

        return \DB::table(static::table)
            ->where('idweek', $data['idweek'])
            ->where('idTeacher', $data['idTeacher'])
            ->where('idTimeslot', $data['idTimeslot'])
            ->update($data);

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
