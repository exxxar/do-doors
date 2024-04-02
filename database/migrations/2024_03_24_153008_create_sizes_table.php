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
        Schema::disableForeignKeyConstraints();

        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->foreignId('material_id')->constrained('materials');
            $table->double('price')->default(0);
            $table->double('price_koef')->default(0);
            $table->integer('loops_count')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
