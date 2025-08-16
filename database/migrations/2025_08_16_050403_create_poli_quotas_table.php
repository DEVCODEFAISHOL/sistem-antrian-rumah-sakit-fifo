<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poli_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->date('quota_date');
            $table->integer('max_quota')->default(20);
            $table->integer('current_count')->default(0);
            $table->timestamps();

            $table->unique(['poli_id', 'quota_date']); // biar tidak dobel data untuk tanggal yg sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poli_quotas');
    }
};
