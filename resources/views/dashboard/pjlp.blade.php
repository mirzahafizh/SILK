
@extends('layouts.app')

@section('title', 'Dashboard PJLP - SILK')

@section('content')
<div class="space-y-7">

    <section>
        <p class="text-sm font-semibold text-poltekba">SISTEM INFORMASI KINERJA PJLP</p>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-2">
            Selamat Datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-slate-500 mt-2">
            Pantau laporan aktivitas kerja harian Anda melalui halaman ini.
        </p>
    </section>

    @php
        $cards = [
            ['Total Laporan', $totalLaporan, 'fa-file-lines', 'bg-blue-50 text-blue-700'],
            ['Menunggu Verifikasi', $menungguVerifikasi, 'fa-clock', 'bg-amber-50 text-amber-700'],
            ['Disetujui', $laporanDisetujui, 'fa-circle-check', 'bg-green-50 text-green-700'],
            ['Perlu Revisi', $perluRevisi, 'fa-rotate-left', 'bg-red-50 text-red-700'],
        ];
    @endphp

    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($cards as $card)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">{{ $card[0] }}</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $card[1] }}</p>
                    </div>

                    <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $card[3] }}">
                        <i class="fa-solid {{ $card[2] }} text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <section class="bg-poltekba rounded-2xl p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div>
            <p class="text-blue-200 text-sm font-semibold">LAPORAN HARIAN</p>
            <h3 class="text-xl sm:text-2xl font-bold mt-2">Sudah melakukan aktivitas hari ini?</h3>
            <p class="text-blue-100 text-sm mt-2">
                Catat pekerjaan Anda agar aktivitas harian terdokumentasi.
            </p>
        </div>

        <a href="{{ route('laporan.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-white text-poltekba font-bold px-5 py-3 rounded-xl hover:bg-blue-50">
            <i class="fa-solid fa-plus"></i> Buat Laporan
        </a>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Laporan Terbaru</h3>
                <p class="text-sm text-slate-500 mt-1">Lima laporan terakhir Anda.</p>
            </div>

            <a href="{{ route('laporan.index') }}" class="text-sm font-semibold text-poltekba hover:underline">
                Lihat semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-left px-6 py-4">Judul</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-right px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($laporanTerbaru as $laporan)
                        @php
                            $statusConfig = [
                                'menunggu_verifikasi' => ['Menunggu Verifikasi', 'bg-amber-100 text-amber-700'],
                                'disetujui' => ['Disetujui', 'bg-green-100 text-green-700'],
                                'perlu_revisi' => ['Perlu Revisi', 'bg-red-100 text-red-700'],
                            ];

                            $status = $statusConfig[$laporan->status] ?? [
                                ucfirst(str_replace('_', ' ', $laporan->status)),
                                'bg-slate-100 text-slate-600'
                            ];
                        @endphp

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                {{ $laporan->judul }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('laporan.show', $laporan->id) }}"
                                    class="text-poltekba font-semibold hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                Belum ada laporan yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
