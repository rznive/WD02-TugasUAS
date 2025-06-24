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
        Schema::create('daftar_polis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('id_jadwal')->constrained('jadwal_periksas')->onDelete('cascade');
            $table->text('keluhan')->nullable();
            $table->string('no_antrian');
            // Unik per jadwal
            $table->unique(['id_jadwal', 'no_antrian']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_polis');
    }
};
