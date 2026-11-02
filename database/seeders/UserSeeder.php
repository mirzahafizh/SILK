<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AKUN ADMIN SILK
        |--------------------------------------------------------------------------
        */

        $admin = [
            [
                'name' => 'Yolanda Vivina Mithaya Sumartono',
                'nip' => '199609292020122003',
            ],
            [
                'name' => 'Ernny Setyowati',
                'nip' => '199110182025212065',
            ],
        ];

        foreach ($admin as $data) {
            User::updateOrCreate(
                ['nip' => $data['nip']],
                [
                    'name' => $data['name'],
                    'email' => $data['nip'] . '@silk.local',
                    'password' => Hash::make($data['nip']),
                    'role' => 'admin',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA PJLP POLITEKNIK NEGERI BALIKPAPAN
        |--------------------------------------------------------------------------
        |
        | Format:
        | [NIP / USERNAME, NAMA]
        |
        | Username = NIP
        | Password = NIP
        |
        */

        $pjlp = [

            // ==========================================
            // SECURITY
            // ==========================================

            ['2025.88.001', 'Agus Suwandi'],
            ['2025.88.002', 'Hendra Permana Muherman'],
            ['2024.90.001', 'Irvani'],
            ['2025.88.028', 'Ixwandi'],
            ['2025.88.003', 'Mirwan Dachhari'],
            ['2025.88.004', 'Suwardi'],
            ['2026.99.009', 'Bokan Radjab Djoko Sambang'],
            ['2026.99.013', 'Charismatic Qalam'],
            ['2026.99.010', 'Hari Wibowo'],
            ['2026.99.012', 'Umar'],
            ['2026.99.019', 'Fatriansyah'],
            ['2026.99.020', 'Muhamat Sarif'],
            ['2026.99.018', 'Selamet Riyadi'],
            ['2026.99.021', 'Rizal Nur Effendi'],
            ['2026.99.022', 'Rudy Apryanto'],
            ['2026.99.023', 'Pinggir Suratmin'],

            // ==========================================
            // DRIVER
            // ==========================================

            ['2025.88.005', 'Anuwar'],
            ['2026.99.017', 'Muhammad Arifin'],

            // ==========================================
            // PRAMUBAKTI
            // ==========================================

            ['2024.90.003', 'Ahmad Mustaqim'],
            ['2009.90.034', 'Busri'],
            ['2015.90.014', 'Eni Susiati'],

            // ==========================================
            // PETUGAS LAYANAN INFORMASI
            // ==========================================

            ['2024.90.002', 'Dina Apriliana'],

            // ==========================================
            // TEKNISI KELISTRIKAN
            // ==========================================

            ['2025.88.006', 'Wahyu Adi Setyawan'],

            // ==========================================
            // CLEANING SERVICE
            // ==========================================

            ['2025.88.007', 'Ade Sundari'],
            ['2025.88.008', 'Dwi Risna Anggriani'],
            ['2025.88.009', 'Fitriani'],
            ['2025.88.010', 'Marlinah'],
            ['2025.88.011', 'Maryani'],
            ['2025.88.013', 'Nur Lisa Anzelia'],
            ['2025.88.014', 'Reniwati'],
            ['2025.88.015', 'Renny'],
            ['2025.88.016', 'Rosmaya'],
            ['2025.88.017', 'Sri Suyani'],
            ['2025.88.018', 'Suci Ayu Rochmaniah'],
            ['2025.88.019', 'Sujiyem'],
            ['2025.88.020', 'Sumarni'],
            ['2025.88.021', 'Suryani'],
            ['2025.88.022', 'Susanti'],
            ['2025.88.023', 'Wita Ristiani'],
            ['2026.99.015', 'Aris Setiawan'],
            ['2026.99.016', 'Dwi Saly Mayasari'],
            ['2026.99.024', 'Ade Rizky Ramadani'],

            // ==========================================
            // TUKANG KEBUN
            // ==========================================

            ['2025.88.024', 'Andi Rusli'],
            ['2025.88.026', 'Edy Siswanto'],
            ['2025.88.027', 'Usrani'],
            ['2026.99.014', 'Tatang Taufik'],

            // ==========================================
            // PEGAWAI ADMINISTRATOR
            // ==========================================

            ['2025.99.001', 'Risa Maudy Cahyani'],
            ['2026.99.001', 'Aulia Umma Fad'],
            ['2026.99.006', 'Bhetran Sorongan'],
            ['2026.99.003', 'Hikmah Nur Aisyah'],
            ['2026.99.004', 'Irnawati'],
            ['2026.99.002', 'Mirza Hafizh Fadillah'],
            ['2026.99.007', 'Vony Fitria Wulan Sari'],
            ['2026.99.005', 'Muhammad Zidny Ilman Fuadi'],
        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA PJLP
        |--------------------------------------------------------------------------
        */

        foreach ($pjlp as $data) {

            $nip = $data[0];
            $nama = $data[1];

            User::updateOrCreate(
                ['nip' => $nip],
                [
                    'name' => $nama,
                    'email' => $nip . '@silk.local',
                    'password' => Hash::make($nip),
                    'role' => 'pjlp',
                ]
            );
        }
    }
}
