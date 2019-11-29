<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('birthday')->default('niente');
            $table->integer('userId');
            $table->string('address')->default('niente');
            $table->string('phone')->default('niente');
            $table->string('postcode')->default('niente');
            $table->string('photo')->default('niente');
            $table->string('gender')->default('niente');
            $table->string('description')->default('niente');
            $table->string('email')->unique();
            $table->string('birthPlace')->default('niente');
            $table->string('fiscalCode')->default('niente');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher');
    }
}
