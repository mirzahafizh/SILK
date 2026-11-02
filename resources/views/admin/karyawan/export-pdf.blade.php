<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja PJLP</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 25px 30px 45px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.5;
        }
/* KOP SURAT */
.kop-wrapper {
    position: relative;
    width: 100%;
    height: 100px;
}

/* Logo terpisah dari teks */
.kop-logo {
    position: absolute;
    left: 250px;
    top: 7px;
    width: 76px;
    height: 76px;
}

.kop-logo img {
    width: 76px;
    height: 76px;
}

/* Teks tetap di tengah */
.kop-text {
    width: 100%;
    text-align: center;
    position: relative;
}

.kementerian {
    font-size: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

.kampus {
    font-size: 19px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 3px;
}

.alamat {
    font-size: 8px;
    margin-top: 4px;
}

.nohp {
    font-size: 8px;
    margin-top: 2px;
}

.nama-sistem {
    font-size: 9px;
    font-weight: bold;
    margin-top: 4px;
}

.garis-kop {
    border-top: 3px solid #000;
    border-bottom: 1px solid #000;
    height: 4px;
    margin-top: 18px;
    margin-bottom: 18px;
}
        /* =========================
           JUDUL DOKUMEN
        ========================= */

        .judul {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul h2 {
            font-size: 15px;
            margin: 0;
            text-transform: uppercase;
        }

        .judul p {
            margin: 4px 0 0;
            font-size: 10px;
        }

        /* =========================
           SECTION
        ========================= */

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 7px;
            color: #0f172a;
        }

        /* =========================
           IDENTITAS PJLP
        ========================= */

        .identity {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .identity td {
            border: 1px solid #cbd5e1;
            padding: 7px 9px;
        }

        .identity .label {
            width: 17%;
            font-weight: bold;
            background: #f1f5f9;
        }

        /* =========================
           REKAPITULASI
        ========================= */

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary td {
            border: 1px solid #cbd5e1;
            text-align: center;
            padding: 9px;
        }

        .summary .number {
            font-size: 16px;
            font-weight: bold;
        }

        .summary .label {
            font-size: 9px;
            color: #475569;
        }

        /* =========================
           DETAIL LAPORAN
        ========================= */

        .report {
            border: 1px solid #cbd5e1;
            margin-bottom: 12px;
            padding: 10px;
            page-break-inside: auto;
        }

        .report-header {
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 7px;
            margin-bottom: 8px;
        }

        .report-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .report-date {
            font-size: 9px;
            color: #64748b;
        }

        .status {
            display: inline-block;
            padding: 3px 7px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 3px;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-revision {
            background: #fee2e2;
            color: #991b1b;
        }

        .description {
            margin-top: 7px;
            text-align: justify;
            white-space: pre-line;
        }

        .note {
            margin-top: 8px;
            padding: 7px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        /* =========================
           FOTO DOKUMENTASI
        ========================= */

        .photo {
            margin-top: 12px;
            text-align: center;
        }

        .photo img {
            width: 380px;
            max-width: 100%;
            height: auto;
            max-height: 280px;
            object-fit: contain;
        }

        /* =========================
           DATA KOSONG
        ========================= */

        .empty {
            text-align: center;
            padding: 25px;
            border: 1px solid #cbd5e1;
            color: #64748b;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
        }

        .page-number:after {
            content: counter(page);
        }

        .page-total:after {
            content: counter(pages);
        }
    </style>
</head>

<body>

 {{-- KOP SURAT --}}
<div class="kop-wrapper">

    <div class="kop-logo">
        <img
            src="{{ public_path('images/logo-poltekba.png') }}"
            alt="Logo Politeknik Negeri Balikpapan"
        >
    </div>

    <div class="kop-text">
        <div class="kementerian">
            Kementerian Pendidikan Tinggi, Sains, dan Teknologi
        </div>

        <div class="kampus">
            Politeknik Negeri Balikpapan
        </div>

        <div class="alamat">
            Jalan Soekarno Hatta Kilometer 8 Balikpapan 76126
        </div>

        <div class="nohp">
            Telepon (0542) 860895
        </div>

        <div class="nama-sistem">
            Laman www.poltekba.ac.id, Surat Elektronik admin@poltekba.ac.id
        </div>
    </div>

</div>

<div class="garis-kop"></div>


    {{-- =========================
         JUDUL DOKUMEN
    ========================= --}}

    <div class="judul">
        <h2>Laporan Kinerja PJLP</h2>
        <p>Periode {{ $tanggalBulan }}</p>
    </div>


    {{-- =========================
         IDENTITAS PEGAWAI
    ========================= --}}

    <div class="section-title">
        A. IDENTITAS PEGAWAI
    </div>

    <table class="identity">
        <tr>
            <td class="label">Nama PJLP</td>
            <td>{{ $karyawan->name }}</td>

            <td class="label">NIP</td>
            <td>{{ $karyawan->nip }}</td>
        </tr>

        <tr>
            <td class="label">Periode</td>
            <td>{{ $tanggalBulan }}</td>

            <td class="label">Jumlah Laporan</td>
            <td>{{ $laporans->count() }} laporan</td>
        </tr>

        <tr>
            <td class="label">Tanggal Cetak</td>
            <td colspan="3">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>


    {{-- =========================
         REKAPITULASI LAPORAN
    ========================= --}}

    <div class="section-title">
        B. REKAPITULASI LAPORAN
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="number">
                    {{ $laporans->count() }}
                </div>
                <div class="label">
                    Total Laporan
                </div>
            </td>

            <td>
                <div class="number">
                    {{ $laporans->where('status', 'menunggu_verifikasi')->count() }}
                </div>
                <div class="label">
                    Menunggu Verifikasi
                </div>
            </td>

            <td>
                <div class="number">
                    {{ $laporans->where('status', 'disetujui')->count() }}
                </div>
                <div class="label">
                    Disetujui
                </div>
            </td>

            <td>
                <div class="number">
                    {{ $laporans->where('status', 'perlu_revisi')->count() }}
                </div>
                <div class="label">
                    Perlu Revisi
                </div>
            </td>
        </tr>
    </table>


    {{-- =========================
         DETAIL LAPORAN KEGIATAN
    ========================= --}}

    <div class="section-title">
        C. DETAIL LAPORAN KEGIATAN
    </div>

    @forelse ($laporans as $index => $laporan)

        <div class="report">

            <div class="report-header">

                <div class="report-title">
                    {{ $index + 1 }}. {{ $laporan->judul }}
                </div>

                <div class="report-date">
                    Tanggal:
                    {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->translatedFormat('d F Y') }}
                </div>

                <div style="margin-top: 5px;">

                    @if ($laporan->status === 'disetujui')

                        <span class="status status-approved">
                            DISETUJUI
                        </span>

                    @elseif ($laporan->status === 'perlu_revisi')

                        <span class="status status-revision">
                            PERLU REVISI
                        </span>

                    @else

                        <span class="status status-pending">
                            MENUNGGU VERIFIKASI
                        </span>

                    @endif

                </div>

            </div>

            <strong>Deskripsi Kegiatan:</strong>

            <div class="description">
                {{ $laporan->deskripsi }}
            </div>


            {{-- CATATAN VERIFIKATOR --}}

            @if ($laporan->catatan_verifikator)

                <div class="note">
                    <strong>Catatan Verifikator:</strong>
                    <br>
                    {{ $laporan->catatan_verifikator }}
                </div>

            @endif


            {{-- FOTO DOKUMENTASI --}}

            @if ($laporan->foto)

                @php
                    $fotoPath = storage_path(
                        'app/public/' . $laporan->foto
                    );
                @endphp

                @if (file_exists($fotoPath))

                    <div class="photo">
                        <strong>Foto Dokumentasi:</strong>
                        <br>

                        <img
                            src="{{ $fotoPath }}"
                            alt="Foto kegiatan"
                        >
                    </div>

                @endif

            @endif

        </div>

    @empty

        <div class="empty">
            Tidak ada laporan kegiatan pada periode ini.
        </div>

    @endforelse


    {{-- =========================
         FOOTER
    ========================= --}}

    <div class="footer">
        Dokumen SILK - Politeknik Negeri Balikpapan
        &nbsp; | &nbsp;
        Halaman <span class="page-number"></span>
        dari <span class="page-total"></span>
    </div>

</body>
</html>