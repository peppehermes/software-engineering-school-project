<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;

class Communications
{
    const table = 'communications';

    /**
     * Retrieve the list of all communications
     *
     * @return \Illuminate\Support\Collection
     */
    public static function retrieveAll(): Collection
    {

        return DB::table(static::table)
            ->select([
                static::table . '.*'
            ])
            ->orderBy(static::table . '.date','DESC')
            ->get();

    }

    public static function retrieveUserAndComm(): Collection
    {

        return DB::table('communications')
            ->select('communications.*', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'communications.idAdmin')
            ->orderby('communications.date', 'desc')
            ->get();

    }


    public static function addNewComm(array $data, $id = null): int
    {

        return \DB::table(static::table)->insert(['description' => $data['description'], 'idAdmin' => $data['idAdmin']]);
    }









}
