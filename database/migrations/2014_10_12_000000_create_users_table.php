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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('email2')->nullable();
            $table->string('name');
            $table->string('lastname');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cellphone')->nullable();
            $table->string('cellphone2')->nullable();
            $table->string('city')->nullable();
            $table->string('city2')->nullable();
            $table->string('uf')->nullable();
            $table->string('uf2')->nullable();
            $table->string('payment')->nullable();
            $table->integer('role');
            $table->boolean('10courses')->nullable();
            $table->string('secretary');
            $table->string('document',11);
            $table->string('seller')->nullable();
            $table->string('courses')->nullable();
            $table->boolean('active');
            $table->boolean('first')->nullable();
            $table->string('image')->default('avatar/default.jpeg');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropSoftDeletes();
        });
    }
};
