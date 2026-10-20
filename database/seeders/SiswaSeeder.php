<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa; // di import model siswa supaya bisa dipakai
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // kelas tempat siswa dimasukkan (dibuat jika belum ada)
        $kelas = Kelas::firstOrCreate(
            ['nama_kelas' => 'XI RPL 1'],
            ['tingkat' => 'XI', 'jurusan' => 'Rekayasa Perangkat Lunak', 'tahun_ajaran' => '2025/2026']
        );

        // data dummy siswa
        $siswa = [
            [
                'nis' => '1001',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'kelas_id' => $kelas->id,
            ],
            [
                'nis' => '1002',
                'nama' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'kelas_id' => $kelas->id,
            ],
        ]; // menampung data dalam bentuk array

        // memasukkan data ke dalam database
        foreach ($siswa as $s) {
            Siswa::updateOrCreate(['nis' => $s['nis']], $s);
        }
    }
}
