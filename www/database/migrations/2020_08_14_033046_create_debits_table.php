<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debits', function (Blueprint $table) {
            $table->id();
            $table->integer('debitable_id')->nullable();
            $table->string('debitable_type')->nullable();
            $table->string('debit_value')->nullable();
            $table->string('debit_type')->nullable();
            $table->string('type_payment')->nullable();
            $table->string('debit_name')->nullable();
            $table->string('debit_paid')->default(0);
            $table->string('order_id')->nullable();
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
        Schema::dropIfExists('debits');
    }
}
