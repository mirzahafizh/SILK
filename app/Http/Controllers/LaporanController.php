<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar bulan yang memiliki laporan.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $bulanLaporans = Laporan::query()
            ->where('user_id', $user->getKey())
            ->selectRaw(
                'YEAR(tanggal) AS tahun,
                 MONTH(tanggal) AS bulan,
                 COUNT(*) AS jumlah_laporan'
            )
            ->groupByRaw('YEAR(tanggal), MONTH(tanggal)')
            ->orderByRaw('YEAR(tanggal) DESC, MONTH(tanggal) DESC')
            ->get();

        return view('laporan.index', compact('bulanLaporans'));
    }

    /**
     * Menampilkan riwayat laporan berdasarkan bulan.
     */
    public function riwayatBulan(Request $request, $year, $month)
    {
        $user = $request->user();

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
            ->where('user_id', $user->getKey())
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);

        $jumlahMenunggu = (clone $query)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        $jumlahDisetujui = (clone $query)
            ->where('status', 'disetujui')
            ->count();

        $laporans = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('laporan.riwayat-bulanan', compact(
            'laporans',
            'tanggalBulan',
            'year',
            'month',
            'jumlahMenunggu',
            'jumlahDisetujui'
        ));
    }

    /**
     * Menampilkan form pembuatan laporan.
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Menyimpan laporan harian.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:150',
            ],
            'tanggal' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'deskripsi' => [
                'required',
                'string',
                'max:5000',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'judul.required' => 'Judul laporan wajib diisi.',
            'judul.max' => 'Judul maksimal 150 karakter.',
            'tanggal.required' => 'Tanggal laporan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal' =>
                'Tanggal laporan tidak boleh melebihi hari ini.',
            'deskripsi.required' => 'Deskripsi pekerjaan wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 5.000 karakter.',
            'foto.image' => 'Dokumentasi harus berupa gambar.',
            'foto.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;

        try {
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')
                    ->store('laporan', 'public');

                if (!$fotoPath) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'foto' => 'Foto gagal diunggah.',
                        ]);
                }
            }

            Laporan::create([
                'user_id' => $request->user()->getKey(),
                'judul' => $validated['judul'],
                'tanggal' => $validated['tanggal'],
                'deskripsi' => $validated['deskripsi'],
                'foto' => $fotoPath,
                'status' => 'menunggu_verifikasi',
                'catatan_verifikator' => null,
            ]);
        } catch (Throwable $exception) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'laporan' => 'Laporan gagal disimpan. Silakan coba kembali.',
                ]);
        }

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }

    /**
     * Menampilkan detail laporan milik PJLP yang login.
     */
    public function show(Request $request, $id)
    {
        $laporan = Laporan::query()
            ->where('user_id', $request->user()->getKey())
            ->findOrFail($id);

        return view('laporan.show', compact('laporan'));
    }

    /**
     * Menghapus laporan yang masih menunggu verifikasi.
     */
    public function destroy(Request $request, $id)
    {
        $laporan = Laporan::query()
            ->where('user_id', $request->user()->getKey())
            ->where('status', 'menunggu_verifikasi')
            ->findOrFail($id);

        $fotoPath = $laporan->foto;

        $laporan->delete();

        if ($fotoPath) {
            Storage::disk('public')->delete($fotoPath);
        }

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    /**
 * Menampilkan halaman edit laporan.
 */
public function edit(Laporan $laporan)
{
    abort_unless($laporan->user_id === auth()->id(), 403);

    abort_unless(
        $laporan->status === 'menunggu_verifikasi',
        403,
        'Laporan yang sudah diverifikasi tidak dapat diedit.'
    );

    return view('laporan.edit', compact('laporan'));
}

/**
 * Memperbarui laporan.
 */
public function update(Request $request, Laporan $laporan)
{
    abort_unless($laporan->user_id === auth()->id(), 403);

    abort_unless(
        $laporan->status === 'menunggu_verifikasi',
        403,
        'Laporan yang sudah diverifikasi tidak dapat diedit.'
    );

    $validated = $request->validate([
        'judul' => 'required|string|max:150',
        'tanggal' => 'required|date|before_or_equal:today',
        'deskripsi' => 'required|string|max:5000',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $validated['foto'] = $request->file('foto')
            ->store('laporan', 'public');
    }

    $laporan->update($validated);

    return redirect()
        ->route('laporan.show', $laporan->id)
        ->with('success', 'Laporan berhasil diperbarui.');
}
}