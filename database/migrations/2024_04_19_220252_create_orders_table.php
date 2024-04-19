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

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number', 255)->nullable()->comment('номер договора');
            $table->dateTime('contract_date')->nullable()->comment('дата договора');
            $table->dateTime('completion_at')->nullable()->comment('Предпологаемая дата сдачи');
            $table->foreignId('client_id')->nullable()->constrained();
            $table->integer('status')->default(0);
            $table->string('source', 255)->nullable()->comment('источник');
            $table->string('contact_person', 255)->nullable()->comment('контактное лицо');
            $table->string('phone', 255)->nullable()->comment('номер телефона');
            $table->string('organizational_form', 255)->nullable()->comment('Форма организации');
            $table->double('contract_amount')->default('0')->comment('сумма договора');
            $table->double('paid')->default('0')->comment('оплачено');
            $table->double('debt')->default('0')->comment('Задолженность');
            $table->double('profit')->default('0')->comment('прибыль');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
