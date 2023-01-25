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
            $table->text('description');
            $table->string('tag');
            $table->string('category');
            $table->string('image')->nullable();
            $table->string('specification')->nullable();
            $table->float('price');
            $table->float('percent')->nullable();
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
