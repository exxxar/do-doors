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
        Schema::table('orders', function (Blueprint $table) {
            $table->string("work_days")->nullable();
            $table->date("delivery_terms")->nullable();
            $table->string("info")->nullable();
            $table->double("total_price")->default(0);
            $table->double("total_count")->default(0);
            $table->double("current_payed")->default(0);
            $table->integer("payed_percent")->default(0);
            $table->json("client_data")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
