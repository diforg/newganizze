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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('description', 255);
            $table->enum('nature', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->date('competence_date');
            $table->date('payment_date')->nullable();
            $table->foreignId('account_id')
                ->constrained('accounts')
                ->restrictOnDelete();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('attachment_url', 500)->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('transfer_id')->nullable();
            $table->foreignId('recurrence_id')
                ->nullable()
                ->constrained('recurrences')
                ->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['account_id', 'competence_date']);
            $table->index(['category_id', 'competence_date']);
            $table->index('status');
            $table->index('recurrence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};