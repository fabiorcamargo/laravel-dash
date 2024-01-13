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
        Schema::create('chatbot_messages', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('motivo')->nullable();
            $table->string('seller')->nullable();
            $table->string('a_fluxo')->nullable();
            $table->string('p_fluxo')->nullable();
            $table->string('tipo')->nullable();
            $table->string('message');
            $table->json('body');
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
        Schema::dropIfExists('chatbot_messages');
    }
};
