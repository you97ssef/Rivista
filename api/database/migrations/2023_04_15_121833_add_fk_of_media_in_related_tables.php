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
        Schema::table('media', function (Blueprint $table) {
            $table->unique('link');
        });

        Schema::table('rivistas', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('media')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('media')->nullOnDelete();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('media')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rivistas', function (Blueprint $table) {
            $table->dropForeign(['image']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['image']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['image']);
        });
    }
};
