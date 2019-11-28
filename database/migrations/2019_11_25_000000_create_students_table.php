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
            $table->string('classId')->default('niente');
            $table->string('birthday')->default('niente');
            $table->string('address')->default('niente');
            $table->string('phone')->default('niente');
            $table->string('postCode')->default('niente');
            $table->string('photo')->default('niente');
            $table->string('gender')->default('niente');
            $table->string('description')->default('niente');
            $table->string('email')->unique()->default('niente');
            $table->string('birthPlace')->default('niente');
            $table->string('fiscalCode')->default('niente');
            $table->string('mailParent1')->default('niente');
            $table->string('mailParent2')->default('niente');
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
