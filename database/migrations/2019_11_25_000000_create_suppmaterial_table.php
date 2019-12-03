<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppmaterial', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idTeach')->default(0);
            $table->string('idClass')->default('niente');
            $table->string('subject')->default('niente');
            $table->string('material');
            $table->string('date')->default('niente');
            $table->string('mdescription')->default('niente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppmaterial');
    }
}
