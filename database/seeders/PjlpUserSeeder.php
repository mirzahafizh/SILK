<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PjlpUserSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = [
            ['Agus Suwandi', '2025.88.001'],
            ['Hendra Permana Muherman', '2025.88.002'],
            ['Irvani', '2024.90.001'],
            ['Ixwandi', '2025.88.028'],
            ['Mirwan Dachhari', '2025.88.003'],
            ['Suwardi', '2025.88.004'],
            ['Bokan Radjab Djoko Sambang', '2026.99.009'],
            ['Charismatic Qalam', '2026.99.013'],
            ['Hari Wibowo', '2026.99.010'],
            ['Umar', '2026.99.012'],
            ['Fatriansyah', '2026.99.019'],
            ['Muhamat Sarif', '2026.99.020'],
            ['Selamet Riyadi', '2026.99.018'],
            ['Rizal Nur Effendi', '2026.99.021'],
            ['Rudy Apryanto', '2026.99.022'],
            ['Pinggir Suratmin', '2026.99.023'],
            ['Anuwar', '2025.88.005'],
            ['Muhammad Arifin', '2026.99.017'],
            ['Ahmad Mustaqim', '2024.90.003'],
            ['Busri', '2009.90.034'],
            ['Eni Susiati', '2015.90.014'],
            ['Dina Apriliana', '2024.90.002'],
            ['Wahyu Adi Setyawan', '2025.88.006'],
            ['Ade Sundari', '2025.88.007'],
            ['Dwi Risna Anggriani', '2025.88.008'],
            ['Fitriani', '2025.88.009'],
            ['Marlinah', '2025.88.010'],
            ['Maryani', '2025.88.011'],
            ['Nur Lisa Anzelia', '2025.88.013'],
            ['Reniwati', '2025.88.014'],
            ['Renny', '2025.88.015'],
            ['Rosmaya', '2025.88.016'],
            ['Sri Suyani', '2025.88.017'],
            ['Suci Ayu Rochmaniah', '2025.88.018'],
            ['Sujiyem', '2025.88.019'],
            ['Sumarni', '2025.88.020'],
            ['Suryani', '2025.88.021'],
            ['Susanti', '2025.88.022'],
            ['Wita Ristiani', '2025.88.023'],
            ['Aris Setiawan', '2026.99.015'],
            ['Dwi Saly Mayasari', '2026.99.016'],
            ['Ade Rizky Ramadani', '2026.99.024'],
            ['Andi Rusli', '2025.88.024'],
            ['Edy Siswanto', '2025.88.026'],
            ['Usrani', '2025.88.027'],
            ['Tatang Taufik', '2026.99.014'],
            ['Risa Maudy Cahyani', '2025.99.001'],
            ['Aulia Umma Fad', '2026.99.001'],
            ['Bhetran Sorongan', '2026.99.006'],
            ['Hikmah Nur Aisyah', '2026.99.003'],
            ['Irnawati', '2026.99.004'],
            ['Mirza Hafizh Fadillah', '2026.99.002'],
            ['Vony Fitria Wulan Sari', '2026.99.007'],
            ['Muhammad Zidny Ilman Fuadi', '2026.99.005'],
        ];

        foreach ($pegawai as [$nama, $nomor]) {
            DB::table('users')->updateOrInsert(
                ['nip' => $nomor],
                [
                    'name' => $nama,
                    'email' => 'pjlp'
                        . str_replace('.', '', $nomor)
                        . '@poltekba.local',
                    'password' => Hash::make($nomor),
                    'role' => 'pjlp',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
