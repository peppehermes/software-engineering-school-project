<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hour');
            $table->string('day');
        });
        DB::table('timeslots')->insert(
            array(
                ['id' => 1,'hour' => '8:00', 'day' =>'Monday'],
                ['id' => 2,'hour' => '9:00', 'day' =>'Monday'],
                ['id' => 3,'hour' => '10:00', 'day' =>'Monday'],
                ['id' => 4,'hour' => '11:00', 'day' =>'Monday'],
                ['id' => 5,'hour' => '12:00', 'day' =>'Monday'],
                ['id' => 6,'hour' => '13:00', 'day' =>'Monday'],
                ['id' => 7,'hour' => '8:00', 'day' =>'Tuesday'],
                ['id' => 8,'hour' => '9:00', 'day' =>'Tuesday'],
                ['id' => 9,'hour' => '10:00', 'day' =>'Tuesday'],
                ['id' => 10,'hour' => '11:00', 'day' =>'Tuesday'],
                ['id' => 11,'hour' => '12:00', 'day' =>'Tuesday'],
                ['id' => 12,'hour' => '13:00', 'day' =>'Tuesday'],
                ['id' => 13,'hour' => '8:00', 'day' =>'Wednesday'],
                ['id' => 14,'hour' => '9:00', 'day' =>'Wednesday'],
                ['id' => 15,'hour' => '10:00', 'day' =>'Wednesday'],
                ['id' => 16,'hour' => '11:00', 'day' =>'Wednesday'],
                ['id' => 17,'hour' => '12:00', 'day' =>'Wednesday'],
                ['id' => 18,'hour' => '13:00', 'day' =>'Wednesday'],
                ['id' => 19,'hour' => '8:00', 'day' =>'Thursday'],
                ['id' => 20,'hour' => '9:00', 'day' =>'Thursday'],
                ['id' => 21,'hour' => '10:00', 'day' =>'Thursday'],
                ['id' => 22,'hour' => '11:00', 'day' =>'Thursday'],
                ['id' => 23,'hour' => '12:00', 'day' =>'Thursday'],
                ['id' => 24,'hour' => '13:00', 'day' =>'Thursday'],
                ['id' => 25,'hour' => '8:00', 'day' =>'Friday'],
                ['id' => 26,'hour' => '9:00', 'day' =>'Friday'],
                ['id' => 27,'hour' => '10:00', 'day' =>'Friday'],
                ['id' => 28,'hour' => '11:00', 'day' =>'Friday'],
                ['id' => 29,'hour' => '12:00', 'day' =>'Friday'],
                ['id' => 30,'hour' => '13:00', 'day' =>'Friday'],
                ['id' => 31,'hour' => '8:00', 'day' =>'Saturday'],
                ['id' => 32,'hour' => '9:00', 'day' =>'Saturday'],
                ['id' => 33,'hour' => '10:00', 'day' =>'Saturday'],
                ['id' => 34,'hour' => '11:00', 'day' =>'Saturday'],
                ['id' => 35,'hour' => '12:00', 'day' =>'Saturday'],
                ['id' => 36,'hour' => '13:00', 'day' =>'Saturday']

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
        Schema::dropIfExists('timeslots');
    }
}
