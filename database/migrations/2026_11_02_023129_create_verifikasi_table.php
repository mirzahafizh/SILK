<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporan')
                ->cascadeOnDelete();

            // Admin yang melakukan verifikasi.
            $table->foreignId('verifikator_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->enum('status', [
                'disetujui',
                'perlu_revisi',
            ]);

            $table->text('catatan')->nullable();

            $table->dateTime('tanggal_verifikasi');

            $table->timestamps();

            $table->index(['laporan_id', 'tanggal_verifikasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
    }
};