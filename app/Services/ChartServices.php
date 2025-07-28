<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ChartServices
{
    /**
     * Get the count of SKPD.
     */
    public function getCountSkpd(): int
    {
        return DB::table('daftar_skpd')->count();
    }

    /**
     * Get the count of applications.
     */
    public function getCountApps(): int
    {
        return DB::table('daftar_aplikasi')->count();
    }

    /**
     * Get the count of websites.
     */
    public function getCountWebsite(): int
    {
        return DB::table('daftar_skpd')
            ->whereNotNull('website')
            ->count();
    }

    /**
     * Get applications grouped by SKPD.
     */
    public function getSkpdAplikasi(): array
    {
        return DB::table('daftar_aplikasi')
            ->join('daftar_skpd', 'daftar_aplikasi.skpd_id', '=', 'daftar_skpd.id')
            ->select('daftar_skpd.alias_skpd as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('daftar_skpd.alias_skpd')
            ->orderByDesc('jumlah')
            ->get()
            ->toArray();
    }

    /**
     * Get applications grouped by type.
     */
    public function getJenisAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('jenis_aplikasi', 'daftar_aplikasi.jenis_aplikasi_id', '=', 'jenis_aplikasi.id')
            ->select('jenis_aplikasi.jenis_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('jenis_aplikasi.jenis_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by category.
     */
    public function getKategoriAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('kategori_aplikasi', 'daftar_aplikasi.kategori_aplikasi_id', '=', 'kategori_aplikasi.id')
            ->select('kategori_aplikasi.kategori_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('kategori_aplikasi.kategori_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by programming language.
     */
    public function getBahasaAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('bahasa_aplikasi', 'daftar_aplikasi.bahasa_aplikasi_id', '=', 'bahasa_aplikasi.id')
            ->select('bahasa_aplikasi.bahasa_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('bahasa_aplikasi.bahasa_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by database.
     */
    public function getDatabaseAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('database_aplikasi', 'daftar_aplikasi.database_aplikasi_id', '=', 'database_aplikasi.id')
            ->select('database_aplikasi.database_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('database_aplikasi.database_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by framework.
     */
    public function getFrameworkAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('framework_aplikasi', 'daftar_aplikasi.framework_aplikasi_id', '=', 'framework_aplikasi.id')
            ->select('framework_aplikasi.framework_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('framework_aplikasi.framework_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by creator.
     */
    public function getPembuatAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('pembuat_aplikasi', 'daftar_aplikasi.pembuat_aplikasi_id', '=', 'pembuat_aplikasi.id')
            ->select('pembuat_aplikasi.pembuat_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('pembuat_aplikasi.pembuat_aplikasi')
            ->get();
    }

    /**
     * Get applications grouped by platform.
     */
    public function getPlatformAplikasi()
    {
        return DB::table('daftar_aplikasi')
            ->join('platform_aplikasi', 'daftar_aplikasi.platform_aplikasi_id', '=', 'platform_aplikasi.id')
            ->select('platform_aplikasi.platform_aplikasi as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('platform_aplikasi.platform_aplikasi')
            ->get();
    }
}
