<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable', function (Blueprint $table) {
            $table->integer('idTeacher');
            $table->string('idClass');
            $table->integer('idTimeslot');
            $table->string('subject');
        });
        DB::table('timetable')->insert(
            array(
                ['idClass' => '1A','idTimeslot' => 2, 'idTeacher' =>1,'subject' => 'Math']
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable');
    }
}
