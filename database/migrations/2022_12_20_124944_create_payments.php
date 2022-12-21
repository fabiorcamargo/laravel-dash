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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('pay_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('dateCreated');
            $table->string('customer');
            $table->string('paymentLink')->nullable();
            $table->string('installment');
            $table->string('dueDate');
            $table->string('value');
            $table->string('netValue');
            $table->string('billingType');
            $table->string('status');
            $table->string('description');
            $table->string('externalReference');
            $table->string('installmentNumber');
            $table->string('invoiceUrl');
            $table->string('bankSlipUrl');
            $table->string('invoiceNumber');
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
        Schema::dropIfExists('payments');
    }
};
