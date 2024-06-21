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
        Schema::table('wp_groups', function (Blueprint $table) {
            $table->foreignId('wp_group_category_id')->constrained('wp_group_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_groups', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
