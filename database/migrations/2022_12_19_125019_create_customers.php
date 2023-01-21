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
            $table->foreignId('user_id')->constrained('users');
            $table->string('gateway_id')->nullable();
            $table->string('dateCreated')->nullable();
            $table->string('cpfCnpj');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('mobilePhone')->nullable();
            $table->string('externalReference')->nullable();
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
