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

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('door_type', 255)->nullable()->comment('Тип двери');
            $table->integer('count')->default(0)->comment('Количество');
            $table->double('price')->default('0')->comment('цена за единицу');
            $table->longText('comment')->nullable();
            $table->longText('purpose')->nullable();
            $table->json('door')->nullable()->comment('параметры двери в json');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
