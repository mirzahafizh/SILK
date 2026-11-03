
@extends('layouts.admin')

@section('title', 'Detail Laporan - SILK')
@section('page-heading', 'Detail Laporan PJLP')
@section('page-description', 'Informasi lengkap dan dokumentasi laporan kinerja pegawai.')

@section('content')

@php
    $statusConfig = [
        'menunggu_verifikasi' => [
            'label' => 'Menunggu Verifikasi',
            'class' => 'bg-amber-100 text-amber-700 border-amber-200',
            'icon' => 'fa-clock',
        ],
        'disetujui' => [
            'label' => 'Disetujui',
            'class' => 'bg-green-100 text-green-700 border-green-200',
            'icon' => 'fa-circle-check',
        ],
        'perlu_revisi' => [
            'label' => 'Perlu Revisi',
            'class' => 'bg-red-100 text-red-700 border-red-200',
            'icon' => 'fa-rotate-left',
        ],
    ];

    $status = $statusConfig[$laporan->status] ?? [
        'label' => ucfirst(str_replace('_', ' ', $laporan->status)),
        'class' => 'bg-slate-100 text-slate-700 border-slate-200',
        'icon' => 'fa-circle-info',
    ];
@endphp

<div class="mx-auto max-w-5xl space-y-6">

    {{-- NAVIGASI --}}
    <div>
        <a href="{{ route('admin.karyawan.months', $karyawan->id) }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba transition hover:text-blue-800">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Riwayat Laporan
        </a>
    </div>

    {{-- HEADER DETAIL --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="bg-poltekba px-6 py-6 text-white">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm text-blue-200">
                        Detail Laporan Kinerja PJLP
                    </p>

                    <h2 class="mt-2 text-xl font-extrabold sm:text-2xl">
                        {{ $laporan->judul }}
                    </h2>

                    <p class="mt-2 text-sm text-blue-100">
                        <i class="fa-solid fa-calendar-days mr-1"></i>
                        {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold">
                        <i class="fa-solid {{ $status['icon'] }}"></i>
                        {{ $status['label'] }}
                    </span>
                </div>

            </div>
        </div>

        {{-- IDENTITAS PEGAWAI --}}
        <div class="grid grid-cols-1 gap-5 border-b border-slate-100 p-6 sm:grid-cols-2">

            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-poltekba">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Nama Pegawai
                    </p>
                    <p class="mt-1 font-bold text-slate-800">
                        {{ $karyawan->name }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-poltekba">
                    <i class="fa-solid fa-id-card text-xl"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Nomor Induk Pegawai
                    </p>
                    <p class="mt-1 font-bold text-slate-800">
                        {{ $karyawan->nip }}
                    </p>
                </div>
            </div>

        </div>

        {{-- DETAIL KEGIATAN --}}
        <div class="space-y-6 p-6">

            <div>
                <h3 class="mb-3 flex items-center gap-2 font-bold text-slate-800">
                    <i class="fa-solid fa-clipboard-list text-poltekba"></i>
                    Deskripsi Kegiatan
                </h3>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                    <p class="whitespace-pre-line text-sm leading-7 text-slate-700">{{ $laporan->deskripsi }}</p>
                </div>
            </div>

            {{-- FOTO KEGIATAN --}}
            <div>
                <h3 class="mb-3 flex items-center gap-2 font-bold text-slate-800">
                    <i class="fa-solid fa-camera text-poltekba"></i>
                    Dokumentasi Kegiatan
                </h3>

                @if($laporan->foto)
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-3">

                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="Buka foto ukuran penuh">

                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                                alt="Dokumentasi {{ $laporan->judul }}"
                                class="mx-auto max-h-[500px] w-full rounded-lg object-contain transition hover:opacity-90">

                        </a>

                        <p class="mt-3 text-center text-xs text-slate-400">
                            Klik foto untuk melihat ukuran penuh.
                        </p>

                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                        <i class="fa-solid fa-image mb-3 text-3xl text-slate-300"></i>
                        <p class="text-sm font-medium text-slate-500">
                            Tidak ada dokumentasi foto.
                        </p>
                    </div>
                @endif
            </div>

            {{-- CATATAN VERIFIKATOR --}}
            <div>
                <h3 class="mb-3 flex items-center gap-2 font-bold text-slate-800">
                    <i class="fa-solid fa-comment-dots text-poltekba"></i>
                    Catatan Verifikator
                </h3>

                @if($laporan->catatan_verifikator)
                    <div class="rounded-xl border {{ $laporan->status === 'perlu_revisi' ? 'border-red-200 bg-red-50' : 'border-slate-200 bg-slate-50' }} p-5">

                        <p class="whitespace-pre-line text-sm leading-7 {{ $laporan->status === 'perlu_revisi' ? 'text-red-700' : 'text-slate-700' }}">
                            {{ $laporan->catatan_verifikator }}
                        </p>

                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5">
                        <p class="text-sm italic text-slate-400">
                            Belum ada catatan dari verifikator.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </section>

    {{-- AKSI VERIFIKASI --}}
@if($laporan->status === 'menunggu_verifikasi')

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER --}}
        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-poltekba">
                    <i class="fa-solid fa-clipboard-check text-lg"></i>
                </div>

                <div>
                    <h3 class="text-base font-bold text-slate-800 sm:text-lg">
                        Verifikasi Laporan
                    </h3>
                    <p class="mt-1 text-sm leading-relaxed text-slate-500">
                        Periksa laporan kegiatan pegawai, kemudian tentukan hasil verifikasi.
                    </p>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 gap-5 p-5 sm:p-6 lg:grid-cols-2">

            {{-- SETUJUI --}}
            <div class="flex flex-col justify-between rounded-xl border border-green-200 bg-green-50/50 p-5">

                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-100 text-green-600">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <h4 class="font-bold text-slate-800">
                            Setujui Laporan
                        </h4>
                    </div>

                    <p class="mb-5 text-sm leading-relaxed text-slate-600">
                        Pilih tindakan ini apabila laporan kegiatan sudah sesuai dan memenuhi ketentuan.
                    </p>
                </div>

                <form action="{{ route('admin.karyawan.verifikasi', $laporan->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menyetujui laporan ini?')">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="disetujui">

                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">

                        <i class="fa-solid fa-check"></i>
                        Setujui Laporan
                    </button>
                </form>
            </div>

            {{-- REVISI --}}
            <div class="rounded-xl border border-red-200 bg-red-50/40 p-5">

                <div class="mb-3 flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>

                    <h4 class="font-bold text-slate-800">
                        Minta Revisi
                    </h4>
                </div>

                <p class="mb-4 text-sm leading-relaxed text-slate-600">
                    Berikan catatan apabila terdapat informasi atau dokumentasi yang perlu diperbaiki.
                </p>

                <form action="{{ route('admin.karyawan.verifikasi', $laporan->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin meminta revisi laporan ini?')">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="perlu_revisi">

                    <label for="catatan" class="mb-2 block text-sm font-semibold text-slate-700">
                        Catatan Revisi
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="catatan"
                        name="catatan"
                        rows="4"
                        required
                        maxlength="2000"
                        placeholder="Tuliskan alasan atau bagian yang perlu diperbaiki..."
                        class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-relaxed text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-400 focus:ring-2 focus:ring-red-100">{{ old('catatan') }}</textarea>

                    @error('catatan')
                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit"
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">

                        <i class="fa-solid fa-rotate-left"></i>
                        Minta Revisi
                    </button>
                </form>
            </div>

        </div>
    </section>

@else

    {{-- STATUS SUDAH DIVERIFIKASI --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

        <div class="flex items-start gap-4">

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                {{ $laporan->status === 'disetujui'
                    ? 'bg-green-100 text-green-600'
                    : 'bg-red-100 text-red-600' }}">

                <i class="fa-solid {{ $status['icon'] }} text-lg"></i>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="font-bold text-slate-800">
                    Laporan Sudah Diverifikasi
                </h3>

                <p class="mt-1 text-sm leading-relaxed text-slate-500">
                    Status laporan saat ini:
                    <span class="font-semibold
                        {{ $laporan->status === 'disetujui'
                            ? 'text-green-600'
                            : 'text-red-600' }}">
                        {{ $status['label'] }}
                    </span>
                </p>

                @if($laporan->catatan_verifikator)
                    <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="mb-1 text-xs font-bold uppercase tracking-wide text-slate-500">
                            Catatan Verifikator
                        </p>

                        <p class="whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $laporan->catatan_verifikator }}</p>
                    </div>
                @endif
            </div>

        </div>
    </section>

@endif

</div>
@endsection
