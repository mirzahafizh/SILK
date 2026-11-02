
@extends('layouts.app')

@section('title', 'Riwayat Laporan - SILK')

@section('content')
<div class="space-y-6">

    <section class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-poltekba">ARSIP AKTIVITAS</p>
            <h2 class="text-2xl font-extrabold text-slate-800 mt-1">Riwayat Laporan</h2>
            <p class="text-sm text-slate-500 mt-2">
                Lihat seluruh laporan harian berdasarkan periode bulan.
            </p>
        </div>

        <a href="{{ route('laporan.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-poltekba hover:bg-poltekba-dark text-white font-bold px-5 py-3 rounded-xl">
            <i class="fa-solid fa-plus"></i>
            Buat Laporan
        </a>
    </section>

    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Periode</p>
            <p class="text-3xl font-extrabold text-poltekba mt-2">
                {{ $bulanLaporans->count() }}
            </p>
            <p class="text-xs text-slate-400 mt-1">Bulan dengan laporan</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Laporan</p>
            <p class="text-3xl font-extrabold text-poltekba mt-2">
                {{ $bulanLaporans->sum('jumlah_laporan') }}
            </p>
            <p class="text-xs text-slate-400 mt-1">Seluruh laporan aktivitas</p>
        </div>
    </section>

    <section>
        <div class="mb-4">
            <h3 class="font-bold text-lg text-slate-800">Arsip Bulanan</h3>
            <p class="text-sm text-slate-500">Pilih periode untuk melihat detail laporan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($bulanLaporans as $bulan)
                @php
                    $tanggalBulan = \Carbon\Carbon::create(
                        (int) $bulan->tahun,
                        (int) $bulan->bulan,
                        1
                    );
                @endphp

                <a href="{{ route('laporan.bulan', [
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
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-10 text-center">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-4"></i>
                    <p class="font-semibold text-slate-700">Belum ada laporan</p>
                    <p class="text-sm text-slate-500 mt-1">
                        Mulai dokumentasikan aktivitas kerja harian Anda.
                    </p>

                    <a href="{{ route('laporan.create') }}"
                        class="inline-flex mt-5 bg-poltekba text-white px-5 py-2.5 rounded-lg text-sm font-bold">
                        Buat Laporan
                    </a>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection
