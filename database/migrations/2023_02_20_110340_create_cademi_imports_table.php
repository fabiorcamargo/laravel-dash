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
        Schema::create('cademi_imports', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('status');
            $table->string('course')->nullable();
            $table->string('code')->nullable();
            $table->string('msg');
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
        Schema::dropIfExists('cademi_imports');
    }
};
