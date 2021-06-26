<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_checks', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_checkable_id')->nullable();
            $table->string('bank_checkable_type')->nullable();
            $table->string('check_date')->nullable();
            $table->string('check_value')->nullable();
            $table->string('increase_value')->nullable();
            $table->string('check_owner')->nullable();
            $table->string('payed_check')->nullable();
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
        Schema::dropIfExists('bank_checks');
    }
}
