<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Isi jenis_aduan
        $jenisAduan = [
            ['jenis_aduan' => 'Bug/Aplikasi Error', 'slug_jenis_aduan' => 'bug-aplikasi-error'],
            ['jenis_aduan' => 'Kinerja Lambat', 'slug_jenis_aduan' => 'kinerja-lambat'],
            ['jenis_aduan' => 'Konten Judi', 'slug_jenis_aduan' => 'konten-judi'],
            ['jenis_aduan' => 'Defacing', 'slug_jenis_aduan' => 'defacing'],
            ['jenis_aduan' => 'Masuk ke Akun Orang Lain', 'slug_jenis_aduan' => 'masuk-ke-akun-orang-lain'],
            ['jenis_aduan' => 'Konten Tidak Pantas', 'slug_jenis_aduan' => 'konten-tidak-pantas'],
            ['jenis_aduan' => 'Keamanan Data', 'slug_jenis_aduan' => 'keamanan-data'],
            ['jenis_aduan' => 'Lainnya', 'slug_jenis_aduan' => 'lainnya'],
        ];

        foreach ($jenisAduan as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('jenis_aduan')->insert($jenisAduan);

        // Aduan Siber
        $aduanSiber = [
            [
                'aplikasi_id' => 1,
                'jenis_aduan_id' => 1,
                'judul_aduan' => 'Error saat submit form pendaftaran',
                'deskripsi_aduan' => 'Setelah mengisi semua field dan klik submit, muncul error 500',
                'url_aduan' => 'https://example.com/register',
                'foto_aduan' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1)
            ],
            [
                'aplikasi_id' => 1,
                'jenis_aduan_id' => 2,
                'judul_aduan' => 'Loading dashboard sangat lambat',
                'url_aduan' => 'https://example.com/dashboard',
                'deskripsi_aduan' => 'Waktu loading dashboard lebih dari 10 detik',
                'foto_aduan' => null,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2)
            ]
        ];

        // Insert and get the IDs
        $aduanSiberIds = [];
        foreach ($aduanSiber as $aduan) {
            $id = DB::table('aduan_siber')->insertGetId($aduan);
            $aduanSiberIds[] = $id;
        }

        // Pelapor
        $pelapor = [
            [
                'aduan_siber_id' => $aduanSiberIds[0],
                'nama_pengadu' => 'Budi Santoso',
                'email_pengadu' => 'budi.santoso@example.com',
                'no_telp_pengadu' => '081234567890',
                'tanggapan' => 'Terima kasih atas laporannya, kami sedang mengecek masalah ini',
                'is_resolved' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1)
            ],
            [
                'aduan_siber_id' => $aduanSiberIds[1],
                'nama_pengadu' => 'Ani Wijaya',
                'email_pengadu' => 'ani.wijaya@example.com',
                'no_telp_pengadu' => '082345678901',
                'tanggapan' => 'Kami sudah mengoptimalkan query database untuk memperbaiki masalah ini',
                'is_resolved' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2)
            ]
        ];

        DB::table('aduan_siber_pelapor')->insert($pelapor);

        // Progres
        $progres = [
            [
                'aduan_siber_id' => $aduanSiberIds[0],
                'status' => 'Diterima',
                'catatan' => 'Laporan telah diterima dan sedang diverifikasi',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'aduan_siber_id' => $aduanSiberIds[0],
                'status' => 'Dalam Proses',
                'catatan' => 'Tim developer sedang mengecek source code terkait error ini',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'aduan_siber_id' => $aduanSiberIds[1],
                'status' => 'Diterima',
                'catatan' => 'Laporan telah diterima',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'aduan_siber_id' => $aduanSiberIds[1],
                'status' => 'Dalam Proses',
                'catatan' => 'Melakukan optimasi query database',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'aduan_siber_id' => $aduanSiberIds[1],
                'status' => 'Selesai',
                'catatan' => 'Masalah telah diperbaiki dan di-deploy ke production',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ]
        ];

        DB::table('progres_aduan_siber')->insert($progres);
    }
}