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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Кто сделал действие
            $table->enum('action_type', ['create', 'update', 'delete'])->default('create'); // create/update/delete
            $table->enum('entity_type', ['client', 'contact', 'delete'])->default('client'); // Client / Contact
            $table->unsignedBigInteger('entity_id'); // id записи
            $table->json('details')->nullable(); // доп. информация
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
