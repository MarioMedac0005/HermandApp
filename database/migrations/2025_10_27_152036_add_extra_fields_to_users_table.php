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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable();
            $table->enum('type', ['band_admin', 'brotherhood_admin', 'guest'])->default('guest');
            $table->foreignId('band_id')->constrained();
            $table->foreignId('brotherhood_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['band_id']);
            $table->dropForeign(['brotherhood_id']);
            $table->dropColumn(['surname', 'type', 'band_id', 'brotherhood_id']);
        });
    }
};
