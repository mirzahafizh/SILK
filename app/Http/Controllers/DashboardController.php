<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard admin.
     */
    public function admin()
    {
        $totalLaporan = Laporan::count();

        $menungguVerifikasi = Laporan::where(
            'status',
            'menunggu_verifikasi'
        )->count();

        $laporanDisetujui = Laporan::where(
            'status',
            'disetujui'
        )->count();

        $perluRevisi = Laporan::where(
            'status',
            'perlu_revisi'
        )->count();

        $totalPegawai = User::where('role', 'pjlp')->count();

        $laporanTerbaru = Laporan::with('user')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalLaporan',
            'menungguVerifikasi',
            'laporanDisetujui',
            'perluRevisi',
            'totalPegawai',
            'laporanTerbaru'
        ));
    }

    /**
     * Dashboard PJLP.
     */
    public function pjlp()
    {
        $user = Auth::user();

        $query = Laporan::where('user_id', $user->id);

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

        $laporanTerbaru = (clone $query)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard.pjlp', compact(
            'totalLaporan',
            'menungguVerifikasi',
            'laporanDisetujui',
            'perluRevisi',
            'laporanTerbaru'
        ));
    }
}