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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['checking', 'savings', 'wallet', 'credit_card', 'investment']);
            $table->string('icon', 50);
            $table->decimal('initial_balance', 15, 2);
            $table->char('currency', 3)->default('BRL');
            $table->boolean('archived')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
