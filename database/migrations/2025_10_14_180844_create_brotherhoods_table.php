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
        Schema::create('brotherhoods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('city', ['Almeria', 'Cadiz', 'Cordoba', 'Granada', 'Huelva', 'Jaen', 'Malaga', 'Sevilla']);
            $table->string('office');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('nazarenes')->nullable();
            $table->year('year_of_founding')->nullable();
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
        Schema::dropIfExists('brotherhoods');
    }
};
