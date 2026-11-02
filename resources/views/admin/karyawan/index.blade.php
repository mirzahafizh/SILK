
@extends('layouts.admin')

@section('title', 'Data Karyawan - SILK')
@section('page-heading', 'Data Karyawan')
@section('page-description', 'Daftar pegawai PJLP dan laporan kinerja.')

@section('content')
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

    <div class="p-5 sm:p-6 border-b border-slate-100">
        <h3 class="font-bold text-lg text-slate-800">Daftar Pegawai PJLP</h3>
        <p class="text-sm text-slate-500 mt-1">
            Pilih pegawai untuk melihat riwayat laporan bulanannya.
        </p>
    </div>

    <div class="p-5 sm:p-6">

        <div class="mb-5">
            <input type="text" id="searchKaryawan"
                placeholder="Cari nama atau NIP..."
                class="w-full sm:max-w-sm rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-poltekba focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tableKaryawan">

                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left px-4 py-4">No.</th>
                        <th class="text-left px-4 py-4">Nama Pegawai</th>
                        <th class="text-left px-4 py-4">NIP</th>
                        <th class="text-center px-4 py-4">Jumlah Laporan</th>
                        <th class="text-right px-4 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($karyawan as $index => $pegawai)
                        <tr>
                            <td class="px-4 py-4">
                                {{ $karyawan->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $pegawai->name }}
                            </td>

                            <td class="px-4 py-4">{{ $pegawai->nip }}</td>

                            <td class="px-4 py-4 text-center">
                                <span class="bg-blue-50 text-poltekba px-3 py-1 rounded-full font-bold">
                                    {{ $pegawai->laporans_count }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('admin.karyawan.months', $pegawai->id) }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-poltekba px-4 py-2 text-white text-xs font-bold hover:bg-poltekba-dark">
                                    <i class="fa-solid fa-folder-open"></i>
                                    Lihat Laporan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-500">
                                Belum ada data pegawai PJLP.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-6">
            {{ $karyawan->links() }}
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchKaryawan').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#tableKaryawan tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush
