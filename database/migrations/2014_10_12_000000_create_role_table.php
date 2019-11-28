<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
        });
        DB::table('role')->insert(
            array(
                ['id' => 1,
                'name' => 'Admin'],
                ['id' => 2,
                'name' => 'Teacher'],
                ['id' => 3,
                'name' => 'Parent'],
                ['id' => 4,
                'name' => 'Class Coordinator'],
                ['id' => 5,
                'name' => 'Super Admin'],
                ['id' => 6,
                'name' => 'Principal']
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
        Schema::dropIfExists('role');
    }
}
