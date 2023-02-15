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
        Schema::create('eco_products', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('tag')->nullable();
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->text('specification')->nullable();
            $table->float('price')->nullable();
            $table->float('percent')->nullable();
            $table->text('flow')->nullable();
            $table->json('comment')->nullable();
            $table->boolean('public');
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
        Schema::dropIfExists('eco_products');
    }
};
