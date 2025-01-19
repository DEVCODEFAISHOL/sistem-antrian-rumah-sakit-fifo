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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('poli_id')->nullable()->constrained('polis')->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('set null');
            $table->string('queue_number');
            $table->enum('priority', ['ringan', 'sedang', 'berat']);
            $table->time('appointment_time')->nullable();
            $table->time('called_time')->nullable(); // tambahkan called_time
            $table->text('keterangan')->nullable();
            $table->text('complaint')->nullable();
            $table->date('checkup_date');
            $table->string('status')->default('waiting');
            $table->integer('estimated_waiting_time')->nullable(); // tambahkan estimated_waiting_time
            $table->enum('jenis_kunjungan', ['baru', 'lama']);
            $table->boolean('is_emergency')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
