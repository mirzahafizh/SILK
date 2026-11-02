
@extends('layouts.admin')

@section('title', 'Dashboard Admin - SILK')
@section('page-heading', 'Dashboard Admin')
@section('page-description', 'Pemantauan dan pengelolaan laporan kinerja PJLP.')

@section('content')
<div class="space-y-7">

    <section>
        <h2 class="text-2xl font-extrabold text-slate-800">
            Selamat Datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-sm text-slate-500 mt-2">
            Berikut ringkasan laporan kinerja pegawai PJLP.
        </p>
    </section>

    @php
        $cards = [
            ['Total Pegawai', $totalPegawai, 'fa-users', 'bg-indigo-50 text-indigo-700'],
            ['Total Laporan', $totalLaporan, 'fa-file-lines', 'bg-blue-50 text-blue-700'],
            ['Menunggu', $menungguVerifikasi, 'fa-clock', 'bg-amber-50 text-amber-700'],
            ['Disetujui', $laporanDisetujui, 'fa-circle-check', 'bg-green-50 text-green-700'],
            ['Perlu Revisi', $perluRevisi, 'fa-rotate-left', 'bg-red-50 text-red-700'],
        ];
    @endphp

    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
        @foreach($cards as $card)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex justify-between items-center gap-2">
                    <div>
                        <p class="text-xs sm:text-sm text-slate-500">{{ $card[0] }}</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $card[1] }}</p>
                    </div>

                    <div class="w-11 h-11 rounded-xl flex items-center justify-center {{ $card[3] }}">
                        <i class="fa-solid {{ $card[2] }} text-lg"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Laporan Terbaru</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Aktivitas pelaporan terbaru dari pegawai.
                </p>
            </div>

            <a href="{{ route('admin.karyawan.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-poltekba hover:underline">
                <i class="fa-solid fa-users"></i> Data Karyawan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left px-6 py-4">Pegawai</th>
                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-left px-6 py-4">Judul Laporan</th>
                        <th class="text-left px-6 py-4">Status</th>
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
                            <td class="px-6 py-4 font-semibold whitespace-nowrap">
                                {{ $laporan->user->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }}
                            </td>

                            <td class="px-6 py-4">{{ $laporan->judul }}</td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                Belum ada laporan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
