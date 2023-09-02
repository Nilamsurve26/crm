<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(1);
            $table->string('password');
            $table->bigInteger('phone')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->string('dob')->nullable();
            $table->string('doj')->nullable();
            $table->integer('mim_id')->nullable();
            $table->string('imei_no')->nullable();
            $table->string('employee_code')->nullable();
            $table->longText('address')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->string('image_path', 100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
