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
        Schema::table('eco_products', function (Blueprint $table) {
            $table->string('course_b')->after('course_id');
            $table->string('course_c')->after('course_b');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eco_products', function (Blueprint $table) {
            $table->dropColumn('course_b');
            $table->dropColumn('course_c');
        });
    }
};
