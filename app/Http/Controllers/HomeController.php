<?php

namespace App\Http\Controllers;

use App\Services\ChartServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(ChartServices $appService)
    {
        // Fetch data from the database
        $data = [
            'countApps'     => DB::table('daftar_aplikasi')->count(),
            'countWebsite'  => DB::table('daftar_skpd')->where('website', '!=', null)->count(),
            'skpdAplikasi' => $appService->getSkpdAplikasi(),
            'jenisAplikasi' => $appService->getJenisAplikasi(),
            'kategoriAplikasi' => $appService->getKategoriAplikasi(),
            'bahasaAplikasi' => $appService->getBahasaAplikasi(),
            'databaseAplikasi' => $appService->getDatabaseAplikasi(),
            'frameworkAplikasi' => $appService->getFrameworkAplikasi(),
            'pembuatAplikasi' => $appService->getPembuatAplikasi(),
            'platformAplikasi' => $appService->getPlatformAplikasi(),
        ];

        // dd($data);
        return view('users.users-index', $data);
    }
}
