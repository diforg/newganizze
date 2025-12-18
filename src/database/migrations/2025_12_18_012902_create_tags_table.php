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
        // Tabela de tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color')->nullable()->default('#6B7280');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabela pivô entre transações e tags
        Schema::create('transaction_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('tag_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();

            // Índices
            $table->unique(['transaction_id', 'tag_id']);
            $table->index('transaction_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_tag');
        Schema::dropIfExists('tags');
    }
};
