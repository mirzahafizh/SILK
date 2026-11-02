@extends('layouts.app')

@section('title', 'Edit Laporan - SILK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('laporan.show', $laporan->id) }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Detail
        </a>

        <h2 class="text-2xl font-extrabold text-slate-800 mt-5">
            Edit Laporan
        </h2>

        <p class="text-sm text-slate-500 mt-2">
            Perbarui informasi laporan aktivitas pekerjaan Anda.
        </p>
    </div>

    <form action="{{ route('laporan.update', $laporan->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 sm:p-8 space-y-6">

        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                Judul Pekerjaan
            </label>

            <input type="text"
                name="judul"
                value="{{ old('judul', $laporan->judul) }}"
                maxlength="150"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-poltekba focus:ring-2 focus:ring-blue-100 outline-none">

            @error('judul')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                Tanggal Kegiatan
            </label>

            <input type="date"
                name="tanggal"
                value="{{ old('tanggal', \Carbon\Carbon::parse($laporan->tanggal)->format('Y-m-d')) }}"
                max="{{ date('Y-m-d') }}"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-poltekba focus:ring-2 focus:ring-blue-100 outline-none">

            @error('tanggal')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                Deskripsi Kegiatan
            </label>

            <textarea name="deskripsi"
                rows="6"
                maxlength="5000"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-poltekba focus:ring-2 focus:ring-blue-100 outline-none resize-y">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>

            @error('deskripsi')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                Dokumentasi Kegiatan
            </label>

            @if($laporan->foto)
                <div class="mb-4">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                        alt="Dokumentasi sebelumnya"
                        class="max-h-64 rounded-xl border border-slate-200 object-contain">

                    <p class="text-xs text-slate-500 mt-2">
                        Foto saat ini. Unggah foto baru jika ingin menggantinya.
                    </p>
                </div>
            @endif

            <input type="file"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-poltekba">

            <p class="text-xs text-slate-500 mt-2">
                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
            </p>

            @error('foto')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="pt-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row justify-end gap-3">

            <a href="{{ route('laporan.show', $laporan->id) }}"
                class="inline-flex justify-center items-center gap-2 rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>

            <button type="submit"
                class="inline-flex justify-center items-center gap-2 rounded-xl bg-poltekba px-5 py-3 text-sm font-bold text-white hover:bg-blue-800 transition">
                <i class="fa-solid fa-save"></i>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>
@endsection