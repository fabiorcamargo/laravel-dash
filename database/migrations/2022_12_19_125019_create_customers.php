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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_id')->nullable();
            $table->string('dateCreated')->nullable();
            $table->string('cpfCnpj');
            $table->string('name');
            $table->string('phone');
            $table->string('mobilePhone');
            $table->string('externalReference')->constrained('users');
            $table->boolean('notificationDisabled')->nullable();
  

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
        Schema::dropIfExists('customers');
    }
};
