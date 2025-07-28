<?php

use function Livewire\Volt\{layout, stat,with};
use App\Models\KatPagesModel;
use App\Models\ProfilModel;
    
with(fn () => 
  [
    'katPages' => KatPagesModel::orderBy('created_at', 'desc')->get(),
    'profil' => \App\Models\ProfilModel::first(),
  ]
);


?>
<header id="header" class="header-main">
    <!--topbar start-->
    <div id="header-top-bar" class="gray-light-bg">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-7 col-lg-7">
                    <div class="topbar-text d-none d-md-block d-lg-block">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="tell:{{ $profil->no_telp ?? '888-1234567' }}" class="d-flex align-items-center gap-2 text-decoration-none">
                                    <span class="fas fa-envelope mr-2"></span> {{ $profil->telp ?? '888-1234567' }}
                                    <span class="fas fa-phone mr-2"></span> {{ $profil->telp ?? '888-1234567' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
    <div class="topbar-text">
        <ul class="list-inline text-end">
            @auth
                <li class="list-inline-item">
                    <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin-index') }}">
                        <span class="fas fa-user mr-2"></span> {{ Auth::user()->name }}
                    </a>
                </li>
                <li class="list-inline-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <span class="fas fa-sign-out-alt mr-2"></span> Logout
                        </a>
                    </form>
                </li>
            @else
                <li class="list-inline-item">
                    <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('login') }}">
                        <span class="fas fa-user mr-2"></span> Login
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>
            </div>
        </div>
    </div>
    <!--topbar end-->

    <!--main header menu start-->
    <div id="logoAndNav" class="main-header-menu-wrap white-bg border-bottom">
        <div class="container">
            <nav class="js-mega-menu navbar navbar-expand-md header-nav">

                <!--logo start-->
                <livewire:partials.logo />
                <!--logo end-->

                <!--responsive toggle button start-->
                <button type="button" class="navbar-toggler btn" aria-expanded="false" aria-controls="navBar" data-bs-toggle="collapse" data-bs-target="#navBar">
                    <span id="hamburgerTrigger">
                        <span class="fas fa-bars"></span>
                    </span>
                </button>
                <!--responsive toggle button end-->

                <!--main menu start-->
                <div id="navBar" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto main-navbar-nav">
                        <!-- Home Menu -->
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link" href="{{ route('users.index') }}">Beranda</a>
                        </li>
                        
                        <!-- RCF2350 Menu -->
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link" href="{{ route('users.rfc235') }}">RCF2350</a>
                        </li>

                        @forelse ($katPages as $katPage)
                            @if ($katPage->pages->count() > 0)
                                <li class="nav-item hs-has-mega-menu custom-nav-item" data-max-width="360px" data-position="right">
                                    <a id="{{ Str::slug($katPage->judul_halaman) }}MegaMenu" class="nav-link custom-nav-link main-link-toggle" href="JavaScript:Void(0);" aria-haspopup="true" aria-expanded="false">
                                        {{ $katPage->judul_halaman }}
                                    </a>
                                    <!-- submenu start -->
                                    <div class="hs-mega-menu main-sub-menu" aria-labelledby="{{ Str::slug($katPage->judul_halaman) }}MegaMenu" style="min-width: 330px;">
                                        @foreach ($katPage->pages as $page)
                                            <div class="title-with-icon-item">
                                                <a class="title-with-icon-link text-decoration-none" href="{{ route('users.detail-halaman', $page->slug_halaman) }}">
                                                    <div class="media d-flex gap-2">
                                                        <div class="media-body">
                                                            <span class="u-header__promo-title">{{ $page->judul_halaman }}</span>
                                                            <small class="u-header__promo-text">
                                                                {{ Str::limit($page->deskripsi_halaman ?? 'Detail informasi', 50) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- submenu end -->
                                </li>
                            @endif
                        @empty
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link" href="#">Tidak ada halaman</a>
                            </li>
                        @endforelse
                        
                        <!-- News Menu -->
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link" href="{{ route('users.berita') }}">Berita</a>
                        </li>

                        <!-- News Menu -->
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link" href="{{ route('users.kontak-kami') }}">Kontak Kami</a>
                        </li>
                        
                        <!-- Report Button -->
                        <li class="nav-item header-nav-last-item d-flex align-items-center">
                            <a class="btn primary-solid-btn animated-btn" href="{{ route('users.aduan') }}" target="_blank">
                                Buat Aduan
                            </a>
                        </li>
                    </ul>
                </div>
                <!--main menu end-->
            </nav>
        </div>
    </div>
    <!--main header menu end-->
</header>