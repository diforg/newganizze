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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('nature', ['income', 'expense', 'both']);
            $table->string('icon', 50);
            $table->string('color', 7);
            $table->foreignId('parent_category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();
            $table->boolean('archived')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
