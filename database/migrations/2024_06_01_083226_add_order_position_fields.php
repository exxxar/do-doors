<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->integer("order_position")->default(0)->after("title");
        });

        Schema::table('handles', function (Blueprint $table) {
            $table->integer("order_position")->default(0)->after("title");
        });

        Schema::table('hinges', function (Blueprint $table) {
            $table->integer("order_position")->default(0)->after("title");
        });

        Schema::table('colors', function (Blueprint $table) {
            $table->integer("order_position")->default(0)->after("title");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
