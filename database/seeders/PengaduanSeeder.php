<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function seedAduanSiber()
    {
        DB::table('aduan_siber')->insert([
            'aplikasi_id' => 1, // Ganti dengan ID aplikasi yang sesuai
            'jenis_aduan_id' => 1,
            'judul_aduan' => 'Contoh Judul Aduan',
            'deskripsi_aduan' => 'Deskripsi lengkap mengenai aduan ini.',
            'foto_aduan' => null, // Ganti dengan nama file foto jika ada
        ]);

        DB::table('aduan_siber_pelapor')->insert([
            'aduan_siber_id' => 1, // Ganti dengan ID aduan siber yang sesuai
            'nama_pengadu' => 'John Doe',
            'email_pengadu' => 'fafas@gmail.com',
            'no_telp_pengadu' => '081234567890',
            'tanggapan' => 'Tanggapan awal terhadap aduan ini.',
            'is_resolved' => false,
        ]);

        DB::table('progres_aduan_siber')->insert([
            'aduan_siber_id' => 1, // Ganti dengan ID aduan siber yang sesuai
            'status' => 'Dalam Proses',
            'catatan' => 'Catatan mengenai progres aduan ini.',
        ]);
    }

    public function run(): void
    {
        $this->seedAduanSiber();
    }
}
