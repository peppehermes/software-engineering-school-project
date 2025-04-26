<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName')->default(null);
            $table->string('lastName')->default(null);
            $table->string('classId')->default('');
            $table->string('birthday')->default('null');
            $table->string('address')->default('null');
            $table->string('phone')->default('null');
            $table->string('postCode')->default('null');
            $table->string('photo')->default('null');
            $table->string('gender')->default('null');
            $table->string('firstYear')->default('null');
            $table->string('description')->default('null');
            $table->string('email')->unique()->default('null');
            $table->string('birthPlace')->default('null');
            $table->string('fiscalCode')->default('null');
            $table->integer('skill')->default(6);
            $table->string('mailParent1')->default('null');
            $table->string('mailParent2')->default('null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
