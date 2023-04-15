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
        Schema::table('rivistas', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('medias')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('medias')->nullOnDelete();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('image')->references('link')->on('medias')->nullOnDelete();
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
