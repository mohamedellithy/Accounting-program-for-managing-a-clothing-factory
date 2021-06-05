<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactionists', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->integer('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); 
            $table->string('reactionist_price')->required();
            $table->string('payment_type')->default('نقدى');    
            $table->string('order_count')->required();  
            $table->string('final_cost')->nullable();   
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
        Schema::dropIfExists('reactionists');
    }
}
