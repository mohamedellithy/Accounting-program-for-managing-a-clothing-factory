<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderClothesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_clothes', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id')->unsigned();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->integer('invoice_no')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('order_size')->required();
            $table->string('order_size_type')->required();
            $table->string('order_price')->required();
            $table->string('payment_type')->required();
            $table->string('order_discount')->nullable();
            $table->string('price_one_piecies')->required();
            $table->string('order_finished')->nullable();
            $table->string('order_follow')->nullable();
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
        Schema::dropIfExists('order_clothes');
    }
}
