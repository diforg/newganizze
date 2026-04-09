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
        Schema::create('recurring_patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->enum('period', [
                'daily', 
                'weekly', 
                'monthly', 
                'quarterly', 
                'yearly'
            ]);
            $table->integer('interval')->default(1); // A cada X períodos
            $table->json('weekdays')->nullable(); // Para recorrência semanal específica
            $table->integer('month_day')->nullable(); // Dia específico do mês
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('count')->nullable(); // Número de ocorrências
            $table->timestamps();

            // Índices
            $table->index('transaction_id');
            $table->index(['period', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_patterns');
    }
};
