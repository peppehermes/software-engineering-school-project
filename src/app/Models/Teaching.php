<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Teaching
{
    const table = 'teaching';

    public static function retrieveSubject($teachingID)
    {
        $result = DB::table('teaching')
            ->select('teaching.subject')
            ->where('teaching.id', $teachingID)
            ->first();

        return $result->subject;

    }

    public static function retrieveTeacher($teachingID)
    {
        $result = DB::table('teaching')
            ->select('teaching.idTeach')
            ->where('teaching.id', $teachingID)
            ->first();

        return $result->idTeach;

    }



}
