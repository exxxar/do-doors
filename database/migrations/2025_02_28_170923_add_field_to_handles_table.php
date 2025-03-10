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
        Schema::table('handles', function (Blueprint $table) {
            $table->string("sku")->nullable();
            $table->longText("comment")->nullable();
            $table->string("brand")->nullable();
            $table->double("weight")->default(0);
            $table->string("material")->nullable();
            $table->longText("material_description")->nullable();
            $table->string("coverage")->nullable();
            $table->string("serial")->nullable();
            $table->string("model")->nullable();
            $table->string("characteristics")->nullable();
            $table->string("base_shape")->nullable();
            $table->double("socket_diameter")->default(0);
            $table->string("square_length")->nullable();
            $table->string("guarantee")->nullable();
            $table->string("dimensions")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('handles', function (Blueprint $table) {
            //
        });
    }
};
