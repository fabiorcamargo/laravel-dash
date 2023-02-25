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
        Schema::create('chatbot_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_id')->nullable();
            $table->string('group_code');
            $table->string('periodo');
            $table->string('group_name');
            $table->string('responsavel');
            $table->string('group_link');
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
        Schema::dropIfExists('chatbot_groups');
    }
};
