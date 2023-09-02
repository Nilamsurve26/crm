<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->integer('status_type_id')->nullable();
            $table->integer('assigned_to_id')->nullable();
            $table->integer('issued_type_id')->nullable();
            $table->integer('priority_type_id')->nullable();
            $table->string('image_path_1')->nullable();
            $table->string('image_path_2')->nullable();
            $table->string('image_path_3')->nullable();
            $table->string('image_path_4')->nullable();
            $table->string('image_path_5')->nullable();
            $table->string('image_path_6')->nullable();
            $table->string('image_path_7')->nullable();
            $table->string('image_path_8')->nullable();
            $table->string('video_path')->nullable();
            $table->integer('created_by_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            
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
        Schema::dropIfExists('tickets');
    }
}
