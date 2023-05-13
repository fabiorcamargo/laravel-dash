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
        Schema::create('flow_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained('flows');
            $table->string('user_id');
            $table->string('step');
            $table->string('seller')->nullable();
            $table->string('product_id')->nullable();
            $table->json('body')->nullable();
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
        Schema::dropIfExists('flow_entries');
    }
};
