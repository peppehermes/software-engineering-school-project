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
            $table->string('birthday')->default('1990-1-1');
            $table->integer('userId');
            $table->string('address')->default('null');
            $table->string('phone')->default('1234567890');
            $table->string('postCode')->default('12345');
            $table->string('photo')->default('null');
            $table->string('gender')->default('M');
            $table->string('description')->default('null');
            $table->string('email')->unique();
            $table->string('birthPlace')->default('');
            $table->string('fiscalCode')->default('GRNMRN78S13C351W');

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
