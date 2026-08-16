<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JamKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin / Pembimbing LPKIA (Maneh)
        User::create([
            'name' => 'Pembimbing LPKIA',
            'email' => 'admin@lpkia.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'nip_nisn' => '12345678',
        ]);

        // 2. Akun Siswa SMK (Contoh)
        User::create([
            'name' => 'Anak SMK PKL',
            'email' => 'siswa@smk.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nip_nisn' => '20260001',
            'qr_code_key' => 'SMK-2026-001',
        ]);

        // 3. Akun Guru Sekolah SMK (View-Only)
        User::create([
            'name' => 'Guru Pembimbing SMK',
            'email' => 'guru@smk.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'nip_nisn' => '87654321',
        ]);

        // 4. Setting Jam Kerja Default (Senin - Sabtu)
        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        foreach ($hari as $h) {
            JamKerja::create([
                'hari' => $h,
                'jam_masuk' => '08:00:00',
                'jam_pulang' => ($h == 'sabtu') ? '14:00:00' : '16:00:00',
                'toleransi_menit' => 15,
            ]);
        }
    }
}