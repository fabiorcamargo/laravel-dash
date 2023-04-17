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
        Schema::create('ouro_lists', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('name');
            $table->string('modulo');
            $table->string('aulas');
            $table->string('carga');
            $table->longText('descricao')->nullable();
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
        Schema::dropIfExists('ouro_lists');
    }
};
