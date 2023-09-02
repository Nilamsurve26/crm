<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('created_by_id')->nullable();
            $table->string('imagepath_1')->nullable();
            $table->string('imagepath_2')->nullable();
            $table->string('imagepath_3')->nullable();
            $table->string('imagepath_4')->nullable();
            $table->string('name')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('barcode')->nullable();
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
        Schema::dropIfExists('products');
    }
}
