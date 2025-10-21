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
        Schema::create('processions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['christ', 'virgin']);
            $table->text('itinerary');
            $table->datetime('checkout_time');
            $table->datetime('checkin_time');
            $table->foreignId('contract_id')->constrained();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processions');
    }
};
