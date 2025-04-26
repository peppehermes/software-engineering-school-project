<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectProgrammingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_programming', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idTeaching');
            $table->integer('totalHours');
        });

        DB::table('subject_programming')->insert(
            array(
                ['idTeaching' => 1, 'totalHours'=>5],
                ['idTeaching' => 2, 'totalHours'=>5],
                ['idTeaching' => 3, 'totalHours'=>5],
                ['idTeaching' => 4, 'totalHours'=>5],
                ['idTeaching' => 5, 'totalHours'=>5],
                ['idTeaching' => 6, 'totalHours'=>5],
                ['idTeaching' => 7, 'totalHours'=>5],
                ['idTeaching' => 8, 'totalHours'=>5],
                ['idTeaching' => 9, 'totalHours'=>5],
                ['idTeaching' => 10, 'totalHours'=>5]
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
        Schema::dropIfExists('subject_programming');
    }
}
