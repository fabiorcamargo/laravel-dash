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
        Schema::create('ouro_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ouro_client_id')->constrained('ouro_clients');
            $table->string('ouro_course_id');
            $table->string('ouro_id');
            $table->string('code');
            $table->string('name');
            $table->date('data_fim');
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
        Schema::dropIfExists('ouro_courses');
    }
};
