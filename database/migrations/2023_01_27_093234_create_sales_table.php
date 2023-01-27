<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('customer')->constrained('customers')->nullable();
            $table->string('codesale')->nullable();
            $table->string('seller')->nullable();
            $table->string('installment')->nullable();
            $table->string('type')->nullable();
            $table->string('id_pay')->nullable();
            $table->string('invoice')->nullable();
            $table->string('bankSlipUrl')->nullable();
            $table->string('status')->nullable();
            $table->string('paymentLink')->nullable();
            $table->string('dueDate')->nullable();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('sales');
    }
};
