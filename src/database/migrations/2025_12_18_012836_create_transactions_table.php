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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Chaves estrangeiras
            $table->foreignId('account_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            
            // Campos principais
            $table->string('description')->nullable();
            $table->json('tags')->nullable(); // Array de tags como JSON
            $table->decimal('amount', 15, 2);
            $table->boolean('recurring')->default(false);
            $table->enum('recurring_period', [
                'daily', 
                'weekly', 
                'monthly', 
                'quarterly', 
                'yearly'
            ])->nullable(); // Período de recorrência
            $table->date('date');
            $table->date('due_date')->nullable(); // Data de vencimento
            $table->date('paid_date')->nullable(); // Data de pagamento
            $table->boolean('paid')->default(false);
            $table->text('notes')->nullable();
            
            // Campos para recorrência
            $table->foreignId('parent_transaction_id')
                  ->nullable()
                  ->constrained('transactions')
                  ->onDelete('cascade');
            $table->date('recurring_end_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('account_id');
            $table->index('category_id');
            $table->index('date');
            $table->index('paid');
            $table->index('recurring');
            $table->index(['date', 'paid']);
            $table->index(['account_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
