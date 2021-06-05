<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostponedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postponeds', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');
            $table->string('posponed_date')->nullable();
            $table->string('posponed_value')->nullable();
            $table->string('posponed_finished')->nullable();
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
        Schema::dropIfExists('postponeds');
    }
}
