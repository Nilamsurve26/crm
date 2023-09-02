<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudValueListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_value_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->string('value_name')->nullable();
            $table->string('description', 100)->nullable();
            $table->string('code', 100)->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('crud_value_lists');
    }
}
