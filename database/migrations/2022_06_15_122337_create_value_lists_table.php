<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValueListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('value_id')->nullable();
            $table->longText('description', 100)->nullable();
            $table->integer('created_by_id');
            $table->string('title')->nullable();
            $table->string('code', 100)->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('value_lists');
    }
}
