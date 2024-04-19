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

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('status', 50)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('fact_address', 255)->nullable();
            $table->longText('comment')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('title', 255)->nullable();
            $table->string('law_address', 255)->nullable();
            $table->string('inn', 20)->nullable();
            $table->string('kpp', 50)->nullable();
            $table->string('ogrn', 50)->nullable();
            $table->string('okpo', 50)->nullable();
            $table->json('requisites')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
