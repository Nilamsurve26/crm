<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('ticket_id')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_attendances');
    }
}
