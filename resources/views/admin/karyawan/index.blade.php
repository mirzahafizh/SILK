
@extends('layouts.admin')

@section('title', 'Data Karyawan - SILK')
@section('page-heading', 'Data Karyawan')
@section('page-description', 'Daftar pegawai PJLP dan laporan kinerja.')

@section('content')
<div class="space-y-6">

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        {{-- Total Pegawai --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-poltekba flex items-center justify-center shrink-0">
                <i class="fa-solid fa-users text-xl"></i>
            </div>

            <div>
                <p class="text-sm text-slate-500 font-medium">
                    Total Pegawai PJLP
                </p>
                <h3 class="text-2xl font-extrabold text-slate-800">
                    {{ $totalPegawai }}
                </h3>
            </div>
        </div>

        {{-- Total Laporan --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-file-circle-check text-xl"></i>
            </div>

            <div>
                <p class="text-sm text-slate-500 font-medium">
                    Total Laporan Pegawai
                </p>
                <h3 class="text-2xl font-extrabold text-slate-800">
                    {{ $totalLaporan }}
                </h3>
            </div>
        </div>

    </div>

    {{-- Daftar Pegawai --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="font-bold text-lg text-slate-800">
                    <i class="fa-solid fa-users text-poltekba mr-2"></i>
                    Daftar Pegawai PJLP
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Pilih pegawai untuk melihat riwayat laporan bulanannya.
                </p>
            </div>

            <span class="inline-flex items-center gap-2 bg-blue-50 text-poltekba px-3 py-2 rounded-lg text-xs font-bold w-fit">
                <i class="fa-solid fa-user-group"></i>
                {{ $totalPegawai }} Pegawai
            </span>
        </div>

        <div class="p-5 sm:p-6">

{{-- Form Pencarian --}}
<div class="mb-5">
    <form action="{{ route('admin.karyawan.index') }}"
          method="GET"
          class="flex flex-col sm:flex-row sm:items-center gap-3 w-full">

        <div class="relative flex-1 w-full">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau NIP pegawai..."
                class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm outline-none transition focus:bg-white focus:border-poltekba focus:ring-4 focus:ring-blue-100">
        </div>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-poltekba px-6 py-3 text-sm font-bold text-white hover:bg-poltekba-dark transition duration-200">
            <i class="fa-solid fa-magnifying-glass"></i>
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.karyawan.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition duration-200">
                <i class="fa-solid fa-xmark"></i>
                Reset
            </a>
        @endif

    </form>
</div>

            {{-- Informasi Hasil Pencarian --}}
            @if(request('search'))
                <div class="mb-5 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">
                    <p class="text-sm text-blue-800">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Hasil pencarian untuk
                        <strong>"{{ request('search') }}"</strong>:
                        <strong>{{ $totalPegawai }}</strong> pegawai ditemukan.
                    </p>
                </div>
            @endif

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-sm">

                    <thead class="bg-poltekba text-white">
                        <tr>
                            <th class="text-center px-5 py-4 font-semibold whitespace-nowrap">
                                No.
                            </th>

                            <th class="text-left px-5 py-4 font-semibold whitespace-nowrap">
                                Nama Pegawai
                            </th>

                            <th class="text-left px-5 py-4 font-semibold whitespace-nowrap">
                                NIP
                            </th>

                            <th class="text-center px-5 py-4 font-semibold whitespace-nowrap">
                                Jumlah Laporan
                            </th>

                            <th class="text-center px-5 py-4 font-semibold whitespace-nowrap">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($karyawan as $index => $pegawai)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200">

                                {{-- Nomor --}}
                                <td class="px-5 py-4 text-center text-slate-500">
                                    {{ $karyawan->firstItem() + $index }}
                                </td>

                                {{-- Nama --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3 min-w-[200px]">

                                        <div class="w-10 h-10 rounded-full bg-blue-50 text-poltekba flex items-center justify-center font-bold shrink-0">
                                            {{ strtoupper(substr($pegawai->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-bold text-slate-800">
                                                {{ $pegawai->name }}
                                            </p>

                                            <p class="text-xs text-slate-400 mt-0.5">
                                                Pegawai PJLP
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                {{-- NIP --}}
                                <td class="px-5 py-4 text-slate-600 font-medium whitespace-nowrap">
                                    {{ $pegawai->nip }}
                                </td>

                                {{-- Jumlah Laporan --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center gap-2 bg-blue-50 text-poltekba px-3 py-1.5 rounded-lg font-bold text-xs">
                                        <i class="fa-solid fa-file-lines"></i>
                                        {{ $pegawai->laporans_count }} Laporan
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.karyawan.months', $pegawai->id) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-poltekba px-4 py-2.5 text-white text-xs font-bold hover:bg-poltekba-dark hover:shadow-md transition duration-200 whitespace-nowrap">

                                        <i class="fa-solid fa-folder-open"></i>
                                        Lihat Laporan
                                    </a>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center">

                                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                            <i class="fa-solid fa-users-slash text-2xl"></i>
                                        </div>

                                        @if(request('search'))
                                            <p class="font-bold text-slate-700">
                                                Pegawai Tidak Ditemukan
                                            </p>

                                            <p class="text-sm text-slate-400 mt-1">
                                                Tidak ada pegawai dengan nama atau NIP tersebut.
                                            </p>
                                        @else
                                            <p class="font-bold text-slate-700">
                                                Belum Ada Data Pegawai
                                            </p>

                                            <p class="text-sm text-slate-400 mt-1">
                                                Data pegawai PJLP belum tersedia.
                                            </p>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Informasi dan Pagination --}}
            @if($karyawan->total() > 0)
                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <p class="text-xs text-slate-500">
                        Menampilkan
                        <strong>{{ $karyawan->firstItem() }}</strong>
                        sampai
                        <strong>{{ $karyawan->lastItem() }}</strong>
                        dari
                        <strong>{{ $karyawan->total() }}</strong>
                        data pegawai.
                    </p>

                    <div>
                        {{ $karyawan->links() }}
                    </div>

                </div>
            @endif

        </div>
    </div>

</div>
@endsection
