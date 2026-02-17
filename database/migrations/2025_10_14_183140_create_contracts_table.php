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
            $table->enum('performance_type', [
                'procession',
                'concert',
                'transfer',
                'festival',
                'other'
            ]);
            $table->date('performance_date');
            $table->text('approximate_route')->nullable();
            $table->integer('duration')->comment('Duration in minutes');
            $table->integer('minimum_musicians')->comment('Minimum number of musicians required');
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('additional_information')->nullable();
            $table->enum('status', [
                'pending', // creado por la hermandad
                'rejected', // rechazado por la banda
                'accepted', // aceptado por la banda
                'signed_by_band', // firmado por la banda
                'signed_by_brotherhood', // firmado por la hermandad
                'completed', // firmado por ambos
                'paid', // pagado
                'payment_failed', // pago fallido
                'expired', // expirado
            ])->default('pending');
            $table->string('pdf_path')->nullable();
            $table->string('band_signed_pdf_path')->nullable();
            $table->string('brotherhood_signed_pdf_path')->nullable();
            $table->string('band_signature_hash')->nullable();
            $table->string('brotherhood_signature_hash')->nullable();
            $table->timestamp('signed_by_band_at')->nullable();
            $table->timestamp('signed_by_brotherhood_at')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('band_id')->constrained()->onDelete('cascade');
            $table->foreignId('brotherhood_id')->constrained()->onDelete('cascade');
            $table->foreignId('procession_id')->nullable()->constrained()->onDelete('cascade');
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
