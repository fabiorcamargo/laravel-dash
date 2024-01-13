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
        Schema::create('user_certificates_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_certificates_models_id')->constrained('user_certificates_models');
            $table->string('name');
            $table->string('type');
            $table->string('percent');
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
        Schema::dropIfExists('user_certificates_conditions');
    }
};
