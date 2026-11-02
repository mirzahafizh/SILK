<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('judul', 150);
            $table->date('tanggal');
            $table->text('deskripsi');

            // Lokasi penyimpanan foto pada public disk.
            $table->string('foto')->nullable();

            // Status verifikasi laporan.
            $table->enum('status', [
                'menunggu_verifikasi',
                'disetujui',
                'perlu_revisi',
            ])->default('menunggu_verifikasi');

            // Catatan dari admin/verifikator.
            $table->text('catatan_verifikator')->nullable();

            $table->timestamps();

            // Mempercepat pencarian laporan berdasarkan pegawai dan tanggal.
            $table->index(['user_id', 'tanggal']);
            $table->index(['status', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};