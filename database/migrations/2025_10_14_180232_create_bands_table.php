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
        Schema::create('bands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('city', ['Almeria', 'Cadiz', 'Cordoba', 'Granada', 'Huelva', 'Jaen', 'Malaga', 'Sevilla'])->nullable();
            $table->string('rehearsal_space')->nullable();
            $table->string('email');
            $table->string('stripe_account_id')->nullable();
            $table->boolean('stripe_onboarding_completed')
              ->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bands');
    }
};
