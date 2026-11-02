
@extends('layouts.app')

@section('title', 'Buat Laporan - SILK')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('laporan.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
        </a>

        <h2 class="text-2xl font-extrabold text-slate-800 mt-5">Buat Laporan Harian</h2>

        <p class="text-sm text-slate-500 mt-2">
            Isi informasi kegiatan dan lampirkan dokumentasi aktivitas kerja Anda.
        </p>
    </div>

    <form action="{{ route('laporan.store') }}" method="POST"
        enctype="multipart/form-data"
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 sm:p-7 space-y-6">

        @csrf

        <div>
            <label for="judul" class="block text-sm font-bold text-slate-700 mb-2">
                Judul Kegiatan <span class="text-red-500">*</span>
            </label>

            <input type="text" id="judul" name="judul"
                value="{{ old('judul') }}"
                maxlength="150" required
                placeholder="Contoh: Pemeliharaan fasilitas kantor"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-poltekba focus:ring-2 focus:ring-blue-100">

            <p class="text-xs text-slate-400 mt-2">Maksimal 150 karakter.</p>
        </div>

        <div>
            <label for="tanggal" class="block text-sm font-bold text-slate-700 mb-2">
                Tanggal Kegiatan <span class="text-red-500">*</span>
            </label>

            <input type="date" id="tanggal" name="tanggal"
                value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                max="{{ now()->format('Y-m-d') }}" required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-poltekba focus:ring-2 focus:ring-blue-100">
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-bold text-slate-700 mb-2">
                Deskripsi Kegiatan <span class="text-red-500">*</span>
            </label>

            <textarea id="deskripsi" name="deskripsi" rows="6"
                maxlength="5000" required
                placeholder="Jelaskan pekerjaan yang dilakukan, lokasi kegiatan, hasil pekerjaan, dan informasi pendukung lainnya..."
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-poltekba focus:ring-2 focus:ring-blue-100">{{ old('deskripsi') }}</textarea>

            <p class="text-xs text-slate-400 mt-2">Maksimal 5.000 karakter.</p>
        </div>

        <div>
            <label for="foto" class="block text-sm font-bold text-slate-700 mb-2">
                Foto Dokumentasi
            </label>

            <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 text-center hover:border-poltekba transition">
                <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400"></i>

                <p class="text-sm font-semibold text-slate-700 mt-3">
                    Pilih foto dokumentasi kegiatan
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </p>

                <input type="file" id="foto" name="foto"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full mt-4 text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-poltekba hover:file:bg-blue-100">
            </div>

            <div id="previewContainer" class="hidden mt-4">
                <p class="text-sm font-semibold text-slate-700 mb-2">Pratinjau foto</p>
                <img id="previewFoto" src="" alt="Pratinjau foto"
                    class="max-h-64 rounded-xl border border-slate-200 object-contain">
                <button type="button" id="hapusFoto"
                    class="mt-2 text-sm text-red-600 font-semibold hover:underline">
                    Hapus foto
                </button>
            </div>
        </div>

        <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
            <div class="flex gap-3">
                <i class="fa-solid fa-circle-info text-poltekba mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold text-poltekba">Informasi</p>
                    <p class="text-xs text-blue-900 leading-relaxed mt-1">
                        Setelah laporan dikirim, laporan akan masuk ke tahap menunggu verifikasi admin.
                        Pastikan informasi yang dimasukkan sudah benar.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-3 border-t border-slate-100">
            <a href="{{ route('laporan.index') }}"
                class="text-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                class="rounded-xl bg-poltekba hover:bg-poltekba-dark px-6 py-3 text-sm font-bold text-white">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Kirim Laporan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    const inputFoto = document.getElementById('foto');
    const previewContainer = document.getElementById('previewContainer');
    const previewFoto = document.getElementById('previewFoto');
    const hapusFoto = document.getElementById('hapusFoto');

    let previewUrl = null;

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        if (!file) {
            previewContainer.classList.add('hidden');
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            alert('Format foto harus JPG, PNG, atau WEBP.');
            this.value = '';
            previewContainer.classList.add('hidden');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            this.value = '';
            previewContainer.classList.add('hidden');
            return;
        }

        previewUrl = URL.createObjectURL(file);
        previewFoto.src = previewUrl;
        previewContainer.classList.remove('hidden');
    });

    hapusFoto.addEventListener('click', function () {
        inputFoto.value = '';
        previewFoto.src = '';
        previewContainer.classList.add('hidden');

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }
    });
</script>
@endpush
