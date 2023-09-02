<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('sub_title', 100)->nullable();
            $table->longText('description')->nullable();
            $table->string('code', 100)->nullable();
            $table->integer('created_by_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
          
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
        Schema::dropIfExists('product_issues');
    }
}
