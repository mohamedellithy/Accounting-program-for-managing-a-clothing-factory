<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostponedOrderClothesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postponed_order_clothes', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchant')->onDelete('cascade');
            $table->string('posponed_value')->nullable();
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
        Schema::dropIfExists('postponed_order_clothes');
    }
}
