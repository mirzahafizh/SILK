@extends('layouts.app')

@section('title', 'Riwayat Bulanan - SILK')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('laporan.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Arsip
        </a>

        <h2 class="text-2xl font-extrabold text-slate-800 mt-5">
            Riwayat Laporan Bulanan
        </h2>

        <p class="text-sm text-slate-500 mt-2">
            Periode {{ $tanggalBulan->translatedFormat('F Y') }}
        </p>
    </div>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Laporan</p>
            <p class="text-3xl font-extrabold text-poltekba mt-2">
                {{ $laporans->total() }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">
                {{ $jumlahMenunggu }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Disetujui</p>
            <p class="text-3xl font-extrabold text-green-600 mt-2">
                {{ $jumlahDisetujui }}
            </p>
        </div>

    </section>

    {{-- Tabel Laporan --}}
    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="p-5 sm:p-6 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">
                Daftar Laporan
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Daftar laporan berdasarkan periode yang dipilih.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4 text-center">No.</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Judul Pekerjaan</th>
                        <th class="px-5 py-4">Deskripsi</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4">Catatan Verifikator</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($laporans as $index => $laporan)
                        @php
                            $statusConfig = [
                                'menunggu_verifikasi' => [
                                    'Menunggu Verifikasi',
                                    'bg-amber-100 text-amber-700'
                                ],
                                'disetujui' => [
                                    'Disetujui',
                                    'bg-green-100 text-green-700'
                                ],
                                'perlu_revisi' => [
                                    'Perlu Revisi',
                                    'bg-red-100 text-red-700'
                                ],
                            ];

                            $status = $statusConfig[$laporan->status] ?? [
                                ucfirst(str_replace('_', ' ', $laporan->status)),
                                'bg-slate-100 text-slate-600'
                            ];
                        @endphp

                        <tr class="hover:bg-slate-50 transition">

                            {{-- Nomor --}}
                            <td class="px-5 py-4 text-center text-slate-500">
                                {{ $laporans->firstItem() + $index }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}
                            </td>

                            {{-- Judul --}}
                            <td class="px-5 py-4 min-w-[180px]">
                                <p class="font-semibold text-slate-800">
                                    {{ $laporan->judul }}
                                </p>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-5 py-4 min-w-[220px] max-w-xs">
                                <p class="text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($laporan->deskripsi, 100) }}
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>
                            </td>

                            {{-- Catatan Verifikator --}}
                            <td class="px-5 py-4 min-w-[180px]">
                                @if($laporan->catatan_verifikator)
                                    <p class="text-sm text-amber-700">
                                        {{ $laporan->catatan_verifikator }}
                                    </p>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Detail --}}
                                    <a href="{{ route('laporan.show', $laporan->id) }}"
                                        title="Lihat Detail"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    {{-- Edit dan Hapus hanya untuk laporan yang belum diverifikasi --}}
                                    @if($laporan->status === 'menunggu_verifikasi')

                                        <a href="{{ route('laporan.edit', $laporan->id) }}"
                                            title="Edit Laporan"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('laporan.destroy', $laporan->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                title="Hapus Laporan"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-xs text-slate-400 whitespace-nowrap">
                                            Tidak dapat diedit
                                        </span>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <i class="fa-solid fa-folder-open text-4xl text-slate-300"></i>
                                <p class="font-semibold text-slate-700 mt-4">
                                    Belum ada laporan
                                </p>
                                <p class="text-sm text-slate-500 mt-1">
                                    Tidak ada laporan pada periode ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($laporans->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $laporans->links() }}
            </div>
        @endif

    </section>

</div>
@endsection