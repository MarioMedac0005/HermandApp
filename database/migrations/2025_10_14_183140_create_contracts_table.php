<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->enum('status', [
                'pending', // creado por la hermandad
                'rejected', // rechazado por la banda
                'accepted', // aceptado por la banda
                'signed_by_band', // firmado por la banda
                'signed_by_brotherhood', // firmado por la hermandad
                'completed', // firmado por ambos
                'expired', // expirado
            ])->default('pending');
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamp('signed_by_band_at')->nullable();
            $table->timestamp('signed_by_brotherhood_at')->nullable();
            $table->foreignId('band_id')->constrained()->onDelete('cascade');
            $table->foreignId('brotherhood_id')->constrained()->onDelete('cascade');
            $table->foreignId('procession_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
