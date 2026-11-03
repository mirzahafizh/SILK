
@extends('layouts.admin')

@section('title', 'Laporan Karyawan - SILK')
@section('page-heading', 'Laporan Kinerja PJLP')
@section('page-description', 'Daftar dan verifikasi laporan kinerja harian PJLP.')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- INFORMASI KARYAWAN --}}
    <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.karyawan.months', $karyawan->id) }}"
               class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-poltekba hover:text-blue-800">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Riwayat Bulanan
            </a>

            <h2 class="text-xl font-bold text-slate-800">
                {{ $karyawan->name }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                NIP: {{ $karyawan->nip }}
            </p>

            <p class="text-sm text-slate-500">
                Periode: {{ $tanggalBulan }}
            </p>
        </div>

        {{-- EXPORT --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.karyawan.export.pdf', [$karyawan->id, $year, $month]) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                <i class="fa-solid fa-file-pdf"></i>
                Export PDF
            </a>

            <a href="{{ route('admin.karyawan.export.excel', [$karyawan->id, $year, $month]) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">
                <i class="fa-solid fa-file-excel"></i>
                Export Excel
            </a>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Laporan</p>
                    <h3 class="mt-2 text-2xl font-bold text-slate-800">
                        {{ $totalLaporan }}
                    </h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <i class="fa-solid fa-file-lines text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
                    <h3 class="mt-2 text-2xl font-bold text-amber-600">
                        {{ $menungguVerifikasi }}
                    </h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Disetujui</p>
                    <h3 class="mt-2 text-2xl font-bold text-green-600">
                        {{ $laporanDisetujui }}
                    </h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Perlu Revisi</p>
                    <h3 class="mt-2 text-2xl font-bold text-red-600">
                        {{ $perluRevisi }}
                    </h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">
                    <i class="fa-solid fa-rotate-left text-xl"></i>
                </div>
            </div>
        </div>

    </section>

    {{-- TABEL LAPORAN --}}
    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-bold text-slate-800">
                    Daftar Laporan Harian
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Laporan kegiatan PJLP pada periode {{ $tanggalBulan }}.
                </p>
            </div>

            <span class="text-sm text-slate-500">
                {{ $laporans->total() }} laporan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] divide-y divide-slate-200">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">No.</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Judul Pekerjaan</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Deskripsi</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Foto</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Catatan Verifikator</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($laporans as $index => $laporan)

                        @php
                            $statusConfig = [
                                'menunggu_verifikasi' => [
                                    'label' => 'Menunggu',
                                    'class' => 'bg-amber-100 text-amber-700',
                                ],
                                'disetujui' => [
                                    'label' => 'Disetujui',
                                    'class' => 'bg-green-100 text-green-700',
                                ],
                                'perlu_revisi' => [
                                    'label' => 'Perlu Revisi',
                                    'class' => 'bg-red-100 text-red-700',
                                ],
                            ];

                            $status = $statusConfig[$laporan->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $laporan->status)),
                                'class' => 'bg-slate-100 text-slate-700',
                            ];
                        @endphp

                        <tr class="transition hover:bg-slate-50">

                            {{-- NOMOR --}}
                            <td class="px-4 py-4 text-sm text-slate-600">
                                {{ $laporans->firstItem() + $index }}
                            </td>

                            {{-- TANGGAL --}}
                            <td class="whitespace-nowrap px-4 py-4">
                                <span class="text-sm font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>

                            {{-- JUDUL --}}
                            <td class="px-4 py-4">
                                <p class="max-w-[200px] text-sm font-semibold text-slate-800">
                                    {{ $laporan->judul }}
                                </p>
                            </td>

                            {{-- DESKRIPSI --}}
                            <td class="px-4 py-4">
                                <p class="max-w-[250px] text-sm text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($laporan->deskripsi, 150) }}
                                </p>
                            </td>

                            {{-- FOTO --}}
                            <td class="px-4 py-4 text-center">
                                @if($laporan->foto)

                                    <button
                                        type="button"
                                        class="btn-preview-foto inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                        data-url="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($laporan->foto) }}"
                                        data-judul="{{ $laporan->judul }}">

                                        <i class="fa-solid fa-image"></i>
                                        Lihat Foto
                                    </button>

                                @else
                                    <span class="text-xs text-slate-400">
                                        Tidak ada foto
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            {{-- CATATAN --}}
                            <td class="px-4 py-4">
                                @if($laporan->catatan_verifikator)
                                    <p class="max-w-[200px] text-sm text-slate-600">
                                        {{ $laporan->catatan_verifikator }}
                                    </p>
                                @else
                                    <span class="text-xs italic text-slate-400">
                                        Belum ada catatan
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
<td class="px-4 py-4">
    <div class="min-w-[180px] space-y-2">

        {{-- DETAIL --}}
        <a href="{{ route('admin.karyawan.laporan.show', $laporan->id) }}"
            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
            <i class="fa-solid fa-eye"></i>
            Lihat Detail
        </a>

        @if($laporan->status === 'menunggu_verifikasi')

            {{-- SETUJUI --}}
            <form
                action="{{ route('admin.karyawan.verifikasi', $laporan->id) }}"
                method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menyetujui laporan ini?')">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="disetujui">

                <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700">
                    <i class="fa-solid fa-check"></i>
                    Setujui
                </button>
            </form>

            {{-- REVISI --}}
            <form
                action="{{ route('admin.karyawan.verifikasi', $laporan->id) }}"
                method="POST"
                class="space-y-2">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="perlu_revisi">

                <textarea
                    name="catatan"
                    rows="3"
                    required
                    maxlength="2000"
                    placeholder="Tuliskan catatan revisi..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"></textarea>

                <button
                    type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin meminta revisi laporan ini?')"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">

                    <i class="fa-solid fa-rotate-left"></i>
                    Minta Revisi
                </button>
            </form>

        @else

            <div class="rounded-lg bg-slate-100 px-3 py-2 text-center text-xs font-medium text-slate-500">
                <i class="fa-solid fa-circle-check mr-1"></i>
                Sudah diverifikasi
            </div>

        @endif

    </div>
</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                        <i class="fa-solid fa-folder-open text-2xl"></i>
                                    </div>

                                    <h4 class="font-semibold text-slate-700">
                                        Belum Ada Laporan
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Belum ada laporan kegiatan pada bulan ini.
                                    </p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($laporans->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $laporans->links() }}
            </div>
        @endif

    </section>

</div>

{{-- ================================================= --}}
{{-- MODAL PREVIEW FOTO --}}
{{-- ================================================= --}}

<div
    id="modalPreviewFoto"
    class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black/80 p-4"
    aria-hidden="true">

    <div
        class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        role="dialog"
        aria-modal="true"
        aria-labelledby="judulModalFoto">

        {{-- HEADER --}}
        <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-4">

            <div class="min-w-0">
                <h3 id="judulModalFoto" class="font-bold text-slate-800">
                    Preview Foto Kegiatan
                </h3>

                <p id="namaFotoModal" class="mt-1 truncate text-xs text-slate-500"></p>
            </div>

            <button
                type="button"
                id="tutupModalFoto"
                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-red-100 hover:text-red-600"
                aria-label="Tutup modal">

                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        {{-- GAMBAR --}}
        <div class="flex max-h-[75vh] min-h-[250px] items-center justify-center overflow-auto bg-slate-950 p-4">

            <img
                id="gambarPreviewModal"
                src=""
                alt="Foto kegiatan PJLP"
                class="max-h-[65vh] max-w-full rounded-lg object-contain">

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-end border-t border-slate-200 px-5 py-3">

            <button
                type="button"
                id="tutupModalFotoFooter"
                class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">

                Tutup
            </button>

        </div>

    </div>
</div>

{{-- JAVASCRIPT MODAL --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('modalPreviewFoto');
    const gambar = document.getElementById('gambarPreviewModal');
    const namaFoto = document.getElementById('namaFotoModal');

    const tombolTutup = document.getElementById('tutupModalFoto');
    const tombolTutupFooter = document.getElementById('tutupModalFotoFooter');

    // Buka modal
    document.querySelectorAll('.btn-preview-foto').forEach(function (button) {

        button.addEventListener('click', function () {

            const url = this.dataset.url;
            const judul = this.dataset.judul;

            gambar.src = url;
            namaFoto.textContent = judul;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        });

    });

    // Tutup modal
    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        gambar.src = '';
        namaFoto.textContent = '';

        document.body.style.overflow = '';
    }

    tombolTutup.addEventListener('click', tutupModal);
    tombolTutupFooter.addEventListener('click', tutupModal);

    // Klik area luar modal
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            tutupModal();
        }
    });

    // Tombol Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            tutupModal();
        }
    });

});
</script>

@endsection
