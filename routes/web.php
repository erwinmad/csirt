<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Form\BeritaForm;
use App\Livewire\Form\FormAplikasi;
use App\Livewire\Form\FormSkpd;
use App\Livewire\Form\PagesForm;
use App\Livewire\Form\TeamForm;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::group(['middleware' => 'firewall.all'], function () {
    Volt::route('/', 'pages.users.index')->name('users.index'); 
    Volt::route('/pengaduan-siber', 'pages.users.pengaduan-siber')->name('users.aduan'); 
    Volt::route('/file', 'pages.users.rfc235')->name('users.rfc235'); 
    Volt::route('/berita', 'pages.users.berita')->name('users.berita'); 
    Volt::route('/kontak-kami', 'pages.users.kontak-kami')->name('users.kontak-kami'); 
    Volt::route('/pages/{slug_halaman}', 'pages.users.detail-halaman')->name('users.detail-halaman'); 
    Volt::route('/berita/{slug_berita}', 'pages.users.detail-berita')->name('users.detail-berita'); 
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // pages/daftar-skdp
    Volt::route('/', 'pages.index')->name('admin-index'); 

    Volt::route('/daftar-skpd', 'pages.daftar-skpd')->name('skpd-list'); 
    Route::get('/daftar-skpd/create', FormSkpd::class)->name('skpd.create'); 
    Route::get('/daftar-skpd/edit/{skpdId}', FormSkpd::class)->name('skpd.edit'); 

    // pages/daftar-website
    Volt::route('/daftar-website', 'pages.daftar-website')->name('website-list'); 

    Volt::route('/detail-aduan/{id}', 'pages.detail-aduan')->name('detail-aduan'); 

    // pages/daftar-aplikasi
    Volt::route('/daftar-aplikasi', 'pages.daftar-aplikasi')->name('aplikasi-list'); 
    Route::get('/daftar-aplikasi/create', FormAplikasi::class)->name('aplikasi.create'); 
    Route::get('/daftar-aplikasi/edit/{aplikasiId}', FormAplikasi::class)->name('aplikasi.edit'); 
    Volt::route('/detail-aplikasi/{aplikasi_id}', 'pages.detail-aplikasi')->name('detail-aplikasi'); 

    //pages/daftar-halaman
    Volt::route('/halaman', 'pages.halaman')->name('pages-list'); 
    Volt::route('/halaman/tambah', PagesForm::class)->name('pages-list.tambah'); 
    Volt::route('/halaman/edit/{pages_id}', PagesForm::class)->name('pages-list.edit');

    //pages/daftar-halaman
    Volt::route('/berita', 'pages.berita')->name('berita-list'); 
    Volt::route('/berita/tambah', BeritaForm::class)->name('berita-list.tambah'); 
    Volt::route('/berita/edit/{beritaId}', BeritaForm::class)->name('berita-list.edit'); 

    //pages/pentest
    Volt::route('/pentest', 'pages.pentest')->name('pentest-list');

    //pages/team-kami
    Volt::route('/team-kami', 'pages.team-kami')->name('team-kami-list');
    Volt::route('/team-kami/tambah', TeamForm::class)->name('team-kami.tambah');
    Volt::route('/team-kami/edit/{id}', TeamForm::class)->name('team-kami.edit');

    //pages/logs
    Volt::route('/logs', 'pages.logs')->name('logs-list');

    //pages/profil
    Volt::route('/profil', 'pages.profil')->name('profil');

    //pages/insiden
    Volt::route('/insiden', 'pages.insiden')->name('insiden-list');

    Route::redirect('settings', 'settings/profile'); 
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile'); 
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance'); 
    
});

require __DIR__.'/auth.php';
