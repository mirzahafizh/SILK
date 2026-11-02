
@extends('layouts.admin')

@section('title', 'Riwayat Laporan - SILK')
@section('page-heading', 'Riwayat Laporan Karyawan')
@section('page-description', 'Pilih bulan untuk melihat laporan harian pegawai.')

@section('content')
<div class="space-y-6">

    <a href="{{ route('admin.karyawan.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:underline">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Karyawan
    </a>

    <section class="bg-white border border-slate-200 rounded-2xl p-6">
        <p class="text-xs font-bold text-poltekba uppercase tracking-wider">
            Informasi Pegawai
        </p>

        <h2 class="text-2xl font-extrabold text-slate-800 mt-2">
            {{ $karyawan->name }}
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            NIP: {{ $karyawan->nip }}
        </p>
    </section>

    <section>
        <h3 class="font-bold text-lg text-slate-800 mb-4">
            Arsip Laporan Bulanan
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

            @forelse($bulanLaporans as $bulan)
                @php
                    $tanggalBulan = \Carbon\Carbon::create(
                        (int) $bulan->tahun,
                        (int) $bulan->bulan,
                        1
                    );
                @endphp

                <a href="{{ route('admin.karyawan.laporan', [
                    'id' => $karyawan->id,
                    'year' => $bulan->tahun,
                    'month' => $bulan->bulan
                ]) }}"
                    class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-poltekba hover:shadow-md transition group">

                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-poltekba flex items-center justify-center">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>

                        <i class="fa-solid fa-arrow-up-right-from-square text-slate-300 group-hover:text-poltekba"></i>
                    </div>

                    <h4 class="font-bold text-lg mt-4 text-slate-800">
                        {{ $tanggalBulan->translatedFormat('F Y') }}
                    </h4>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $bulan->jumlah_laporan }} laporan
                    </p>

                </a>

            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-500">
                    <i class="fa-solid fa-folder-open text-3xl mb-3"></i>
                    <p>Belum ada laporan dari pegawai ini.</p>
                </div>
            @endforelse

        </div>
    </section>

</div>
@endsection
