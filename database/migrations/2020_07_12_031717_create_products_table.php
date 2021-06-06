<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name_product')->nullable();
            $table->string('cloth_styles_id')->nullable();
            $table->foreign('cloth_styles_id')->references('id')->on('cloth_styles')->onDelete('cascade');
            $table->integer('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('count_piecies')->nullable();
            $table->string('price_piecies')->nullable();
            $table->string('additional_taxs')->nullable();
            $table->string('full_price')->nullable();     
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
