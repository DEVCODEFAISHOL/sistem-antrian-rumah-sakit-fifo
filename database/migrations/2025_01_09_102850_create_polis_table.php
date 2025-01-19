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
        Schema::create('polis', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama'); // Nama poli (misalnya, "Poli Penyakit Dalam")
            $table->string('kode_poli')->unique(); // Kode unik poli (misalnya, "PD")
            $table->text('deskripsi')->nullable(); // Deskripsi poli (opsional)
            $table->string('lokasi')->nullable(); // Lokasi poli (misalnya, "Lantai 2, Ruang 201")
            $table->integer('kapasitas_harian')->default(0); // Kapasitas harian poli
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('set null'); // Relasi ke tabel dokters
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polis');
    }
};
