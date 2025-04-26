<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('subjectId');
            $table->string('subjectName');
        });

        DB::table('subjects')->insert(
            array(
                    ['subjectName' => 'Math'],
                    ['subjectName' => 'Italian'],
                    ['subjectName' => 'Art'],
                    ['subjectName' => 'Latin'],
                    ['subjectName' => 'History'],
                    ['subjectName' => 'English'],
                    ['subjectName' => 'Gym'],
                    ['subjectName' => 'Physics'],
                    ['subjectName' => 'Science'],
                    ['subjectName' => 'Religion']
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
        Schema::dropIfExists('subjects');
    }
}
