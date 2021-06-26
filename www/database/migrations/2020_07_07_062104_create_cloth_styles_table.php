<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloth_styles', function (Blueprint $table) {
            $table->id();
            $table->string('name_piecies');
            $table->string('order_clothes_id');
            $table->foreign('order_clothes_id')->references('id')->on('order_clothes')->onDelete('cascade');
            $table->integer('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('count_piecies');
            $table->string('price_piecies');
            $table->string('additional_taxs');
            $table->string('full_price');             
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
        Schema::dropIfExists('cloth_styles');
    }
}
