<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminKaryawanController extends Controller
{

public function showLaporan(Laporan $laporan)
{
    $karyawan = User::findOrFail($laporan->user_id);

    return view('admin.karyawan.show', compact(
        'laporan',
        'karyawan'
    ));
}
    /**
     * Menampilkan seluruh karyawan PJLP.
     */
public function index(Request $request)
{
    $query = User::query()
        ->where('role', 'pjlp')
        ->withCount('laporans');

    // Pencarian seluruh data pegawai berdasarkan nama atau NIP
    if ($request->filled('search')) {
        $keyword = $request->search;

        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'LIKE', "%{$keyword}%")
              ->orWhere('nip', 'LIKE', "%{$keyword}%");
        });
    }

    // Statistik mengikuti hasil pencarian, bukan hanya halaman aktif
    $totalPegawai = (clone $query)->count();

    $totalLaporan = (clone $query)
        ->get()
        ->sum('laporans_count');

    // Pagination tetap mempertahankan kata kunci pencarian
    $karyawan = $query
        ->orderBy('name', 'asc')
        ->paginate(10)
        ->withQueryString();

    return view('admin.karyawan.index', compact(
        'karyawan',
        'totalPegawai',
        'totalLaporan'
    ));
}

    /**
     * Menampilkan daftar bulan laporan milik karyawan.
     */
    public function months($id)
    {
        $karyawan = User::query()
            ->where('role', 'pjlp')
            ->findOrFail($id);

        $bulanLaporans = Laporan::query()
            ->where('user_id', $karyawan->id)
            ->selectRaw(
                'YEAR(tanggal) AS tahun,
                 MONTH(tanggal) AS bulan,
                 COUNT(*) AS jumlah_laporan'
            )
            ->groupByRaw('YEAR(tanggal), MONTH(tanggal)')
            ->orderByRaw('YEAR(tanggal) DESC, MONTH(tanggal) DESC')
            ->get();

        return view('admin.karyawan.months', compact(
            'karyawan',
            'bulanLaporans'
        ));
    }

    /**
     * Menampilkan laporan karyawan pada bulan tertentu.
     */
    public function laporan($id, $year, $month)
    {
        $karyawan = User::query()
            ->where('role', 'pjlp')
            ->findOrFail($id);

        $year = (int) $year;
        $month = (int) $month;

        abort_unless(
            $year >= 2000 &&
            $year <= 2100 &&
            checkdate($month, 1, $year),
            404
        );

        $tanggalBulan = Carbon::createFromDate(
            $year,
            $month,
            1
        )->locale('id');

        $query = Laporan::query()
            ->with('user')
            ->where('user_id', $karyawan->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);

        $totalLaporan = (clone $query)->count();

        $menungguVerifikasi = (clone $query)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        $laporanDisetujui = (clone $query)
            ->where('status', 'disetujui')
            ->count();

        $perluRevisi = (clone $query)
            ->where('status', 'perlu_revisi')
            ->count();

        $laporans = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.karyawan.laporan', compact(
            'karyawan',
            'laporans',
            'tanggalBulan',
            'year',
            'month',
            'totalLaporan',
            'menungguVerifikasi',
            'laporanDisetujui',
            'perluRevisi'
        ));
    }

    /**
     * Memverifikasi laporan karyawan.
     */
    public function verifikasi(Request $request, $id)
    {
        // Form Blade menggunakan nama input "catatan".
        $validated = $request->validate([
            'status' => [
                'required',
                'in:disetujui,perlu_revisi',
            ],
            'catatan' => [
                'nullable',
                'required_if:status,perlu_revisi',
                'string',
                'max:2000',
            ],
        ], [
            'status.required' => 'Status verifikasi wajib dipilih.',
            'status.in' => 'Status verifikasi tidak valid.',
            'catatan.required_if' =>
                'Catatan wajib diisi apabila laporan perlu direvisi.',
            'catatan.max' =>
                'Catatan maksimal 2.000 karakter.',
        ]);

        $laporan = Laporan::findOrFail($id);

        // Hanya laporan yang menunggu verifikasi yang dapat diproses.
        if ($laporan->status !== 'menunggu_verifikasi') {
            return back()->with(
                'error',
                'Laporan ini sudah pernah diverifikasi.'
            );
        }

        $laporan->update([
            'status' => $validated['status'],
            'catatan_verifikator' =>
                $validated['status'] === 'perlu_revisi'
                    ? $validated['catatan']
                    : null,
        ]);

        return back()->with(
            'success',
            $validated['status'] === 'disetujui'
                ? 'Laporan berhasil disetujui.'
                : 'Laporan berhasil dikembalikan untuk revisi.'
        );
    }

    /**
     * Mengambil laporan untuk kebutuhan ekspor.
     */
    private function getLaporanExport($id, $year, $month)
    {
        $karyawan = User::query()
            ->where('role', 'pjlp')
            ->findOrFail($id);

        $year = (int) $year;
        $month = (int) $month;

        abort_unless(
            $year >= 2000 &&
            $year <= 2100 &&
            checkdate($month, 1, $year),
            404
        );

        $laporans = Laporan::query()
            ->with('user')
            ->where('user_id', $karyawan->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        $tanggalBulan = Carbon::createFromDate(
            $year,
            $month,
            1
        )->locale('id');

        return compact(
            'karyawan',
            'laporans',
            'year',
            'month',
            'tanggalBulan'
        );
    }

    /**
     * Ekspor laporan ke PDF.
     */
    public function exportPdf($id, $year, $month)
    {
        $data = $this->getLaporanExport($id, $year, $month);

        $pdf = Pdf::loadView(
            'admin.karyawan.export-pdf',
            $data
        )->setPaper('a4', 'landscape');

        $namaFile = 'laporan-pjlp-'
            . $data['karyawan']->nip
            . '-'
            . $data['year']
            . '-'
            . str_pad(
                (string) $data['month'],
                2,
                '0',
                STR_PAD_LEFT
            )
            . '.pdf';

        return $pdf->download($namaFile);
    }

    /**
     * Ekspor laporan ke CSV yang dapat dibuka dengan Excel.
     */
    public function exportExcel($id, $year, $month): StreamedResponse
    {
        $data = $this->getLaporanExport($id, $year, $month);

        $karyawan = $data['karyawan'];
        $laporans = $data['laporans'];

        $namaFile = 'laporan-pjlp-'
            . $karyawan->nip
            . '-'
            . $data['year']
            . '-'
            . str_pad(
                (string) $data['month'],
                2,
                '0',
                STR_PAD_LEFT
            )
            . '.csv';

        return response()->streamDownload(function () use (
            $karyawan,
            $laporans,
            $data
        ) {
            $handle = fopen('php://output', 'w');

            // BOM agar karakter UTF-8 terbaca dengan baik oleh Excel.
            fwrite($handle, "\xEF\xBB\xBF");

            // Informasi karyawan.
            fputcsv($handle, ['LAPORAN KINERJA PJLP'], ';');
            fputcsv($handle, ['NIP', $karyawan->nip], ';');
            fputcsv($handle, ['Nama', $karyawan->name], ';');

            fputcsv($handle, [
                'Periode',
                $data['tanggalBulan']->translatedFormat('F Y'),
            ], ';');

            fputcsv($handle, [], ';');

            // Header tabel.
            fputcsv($handle, [
                'No',
                'Tanggal',
                'Judul Pekerjaan',
                'Deskripsi',
                'Status',
                'Catatan Verifikator',
            ], ';');

            foreach ($laporans as $index => $laporan) {
                fputcsv($handle, [
                    $index + 1,
                    $laporan->tanggal
                        ? Carbon::parse($laporan->tanggal)->format('d-m-Y')
                        : '-',
                    $laporan->judul,
                    $laporan->deskripsi,
                    $laporan->status,
                    $laporan->catatan_verifikator ?? '-',
                ], ';');
            }

            fclose($handle);
        }, $namaFile, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
