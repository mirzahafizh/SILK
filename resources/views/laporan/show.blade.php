@extends('layouts.app')

@section('title', 'Detail Laporan - SILK')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('laporan.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:underline transition">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        <div class="mt-5">
            <p class="text-xs font-bold uppercase tracking-widest text-poltekba">
                Sistem Informasi Kinerja PJLP
            </p>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-2">
                Detail Laporan
            </h2>

            <p class="text-sm text-slate-500 mt-2">
                Informasi lengkap laporan aktivitas kerja Anda.
            </p>
        </div>
    </div>

    @php
        $statusConfig = [
            'menunggu_verifikasi' => [
                'Menunggu Verifikasi',
                'bg-amber-50 text-amber-700 border-amber-200',
                'fa-clock'
            ],
            'disetujui' => [
                'Disetujui',
                'bg-green-50 text-green-700 border-green-200',
                'fa-circle-check'
            ],
            'perlu_revisi' => [
                'Perlu Revisi',
                'bg-red-50 text-red-700 border-red-200',
                'fa-circle-exclamation'
            ],
        ];

        $status = $statusConfig[$laporan->status] ?? [
            ucfirst(str_replace('_', ' ', $laporan->status)),
            'bg-slate-50 text-slate-600 border-slate-200',
            'fa-circle-info'
        ];
    @endphp

    {{-- Detail Laporan --}}
    <article class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Judul dan Status --}}
        <div class="p-5 sm:p-8 border-b border-slate-100">

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">

                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-poltekba bg-blue-50 rounded-lg px-3 py-2">
                        <i class="fa-solid fa-file-lines"></i>
                        LAPORAN AKTIVITAS KERJA
                    </div>

                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-800 mt-4 leading-snug uppercase">
                        {{ $laporan->judul }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 text-justify">
                        <i class="fa-regular fa-calendar mr-2 text-poltekba"></i>
                        {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <span class="inline-flex items-center gap-2 w-fit shrink-0 rounded-full border px-4 py-2 text-xs font-bold {{ $status[1] }}">
                    <i class="fa-solid {{ $status[2] }}"></i>
                    {{ $status[0] }}
                </span>

            </div>
        </div>

        <div class="p-5 sm:p-8 space-y-8">

            {{-- Deskripsi --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-poltekba">
                        <i class="fa-solid fa-align-left"></i>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-800">
                            Deskripsi Kegiatan
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">
                            Rincian aktivitas pekerjaan yang dilaksanakan.
                        </p>
                    </div>
                </div>

                <div class="rounded-xl bg-slate-50 border border-slate-200 p-5 sm:p-6">
                    <p class="text-sm text-slate-700 leading-7 whitespace-pre-line">{{ $laporan->deskripsi }}</p>
                </div>
            </section>

            {{-- Dokumentasi --}}
            @if($laporan->foto)
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-poltekba">
                            <i class="fa-solid fa-camera"></i>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-800">
                                Dokumentasi Kegiatan
                            </h4>
                            <p class="text-xs text-slate-500 mt-1">
                                Foto pendukung aktivitas pekerjaan.
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="block group">

                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                                alt="Foto dokumentasi kegiatan"
                                class="max-h-[450px] w-full rounded-lg object-contain transition group-hover:opacity-90">

                            <p class="text-xs text-center text-slate-500 mt-3">
                                <i class="fa-solid fa-up-right-from-square mr-1"></i>
                                Klik foto untuk melihat ukuran penuh
                            </p>
                        </a>
                    </div>
                </section>
            @endif

            {{-- Catatan Verifikator --}}
            @if($laporan->catatan_verifikator)
                <section>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 sm:p-6">

                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 text-amber-700">
                                <i class="fa-solid fa-comment-dots"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-amber-900">
                                    Catatan Verifikator
                                </h4>
                                <p class="text-xs text-amber-700 mt-1">
                                    Informasi dan tanggapan terhadap laporan Anda.
                                </p>
                            </div>
                        </div>

                        <p class="text-sm text-amber-900 mt-4 leading-7 whitespace-pre-line">
                            {{ $laporan->catatan_verifikator }}
                        </p>

                    </div>
                </section>
            @endif

            {{-- Aksi --}}
            <div class="pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">

                @if($laporan->status === 'menunggu_verifikasi')
                    <form action="{{ route('laporan.destroy', $laporan->id) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-red-600 hover:bg-red-700 px-5 py-3 text-sm font-bold text-white transition">
                            <i class="fa-solid fa-trash"></i>
                            Hapus Laporan
                        </button>
                    </form>
                @endif

            </div>

        </div>
    </article>

</div>
@endsection