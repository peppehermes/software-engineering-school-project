<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text')->default('niente');
            $table->string('subject')->default('niente');
            $table->string('topic')->default('niente');
            $table->string('date')->default('niente');
            $table->string('attachment')->default('niente');
            $table->integer('idTeach');
            $table->string('idClass');
            $table->string('deadline')->default('niente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
