<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SKPDSeeder extends Seeder
{

    public function run()
    {
        // Seeder untuk tabel kategori_skpd
        DB::table('kategori_skpd')->insert([
            [
                'kategori_skpd' => 'Dinas',
                'slug_kategori_skpd' => 'dinas',
            ],
            [
                'kategori_skpd' => 'Badan',
                'slug_kategori_skpd' => 'badan',
            ],
            [
                'kategori_skpd' => 'BLUD',
                'slug_kategori_skpd' => 'blud',
            ],
            [
                'kategori_skpd' => 'Sekretariat',
                'slug_kategori_skpd' => 'sekretariat',
            ],
            [
                'kategori_skpd' => 'Satuan',
                'slug_kategori_skpd' => 'satuan',
            ],
            [
                'kategori_skpd' => 'Kecamatan',
                'slug_kategori_skpd' => 'kecamatan',
            ]
        ]);

        // Seeder untuk tabel daftar_skpd
        DB::table('daftar_skpd')->insert([
            [
                'nama_skpd' => 'Dinas Komunikasi Informatika dan Persandian',
                'alias_skpd' => 'Diskominfo',
                'slug_skpd' => 'diskominfo',
                'skpd_id' => 1,
                'email_skpd' => 'diskominfo@cianjurkab.go.id',
                'no_telp_skpd' => '081234567890',
                'website_skpd' => 'https://diskominfo.cianjurkab.go.id',
                'logo_skpd' => 'disdik-logo.png',
                'alamat_skpd' => 'Jl. Abdullah Bin Nuh',
            ],
        ]);
    }
}
