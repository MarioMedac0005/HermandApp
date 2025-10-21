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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->enum('status', ['expired', 'pending', 'active'])->default('pending');
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable(); 
            $table->foreignId('procession_id')->constrained();
            $table->foreignId('band_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
