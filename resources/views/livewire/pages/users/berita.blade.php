<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\BeritaModel;

new 
#[Layout('components.layouts.guest')]
class extends Component {

    public function with(): array
    {
        return [
            'posts' => BeritaModel::orderBy('tgl_berita', 'desc')->paginate(8),
            'popular_posts' => BeritaModel::orderBy('views', 'desc')->paginate(6),
        ];
    }
   
}; ?>

<div class="main">
    <!--page header section start-->
    <section class="page-header-section ptb-100 gradient-overly-right" style="background: url('{{ asset('assets-v2/img/bg/7.png') }}')no-repeat center center / cover">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-6">
                    <div class="page-header-content text-white">
                        <h1 class="text-white mb-2">Berita Seputar CSIRT</h1>
                        <p class="lead">Dapatkan informasi terbaru dan perkembangan terkini dari Kabupaten Cianjur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--page header section end-->

    <!--breadcrumb bar start-->
    <div class="breadcrumb-bar py-3 gray-light-bg border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="custom-breadcrumb">
                        <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0 pl-0">
                            <li class="list-inline-item breadcrumb-item"><a class="text-decoration-none" href="{{ route('users.index') }}">Home</a></li>
                            <li class="list-inline-item breadcrumb-item active">Berita</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb bar end-->

    <!--blog section start-->
    <div class="module ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="sidebar-left pe-4">
                        <!-- Search widget-->
                        <aside class="widget widget-search">
                            <form>
                                <input class="form-control" type="search" placeholder="Cari berita...">
                                <button class="search-button" type="submit"><span class="ti-search"></span></button>
                            </form>
                        </aside>

                        <!-- Recent entries widget-->
                        <aside class="widget widget-recent-entries-custom">
                            <div class="widget-title">
                                <h6>Berita Populer</h6>
                            </div>
                            <ul>
                                @forelse ($popular_posts as $popular)
                                @php
                                    $popularGambarArray = json_decode($popular->gambar, true);
                                    $popularThumbnail = is_array($popularGambarArray) && count($popularGambarArray) > 0 
                                                      ? asset(trim($popularGambarArray[0], '\"')) 
                                                      : asset('assets/img/placeholder.jpg');
                                @endphp
                                
                                <li class="clearfix">
                                    <div class="wi">
                                        <a href="{{ route('users.detail-berita', $popular->slug_berita) }}">
                                            <img src="{{ $popularThumbnail }}" alt="{{ $popular->judul_berita }}" class="img-fluid rounded" />
                                        </a>
                                    </div>
                                    <div class="wb">
                                        <a class="text-decoration-none" href="{{ route('users.detail-berita', $popular->slug_berita) }}">
                                            {{ Str::limit($popular->judul_berita, 50) }}
                                        </a>
                                        <span class="post-date">
                                            {{ \Carbon\Carbon::parse($popular->tgl_berita)->translatedFormat('j M Y') }}
                                        </span>
                                    </div>
                                </li>
                                @empty
                                <li>Tidak ada berita populer</li>
                                @endforelse
                            </ul>
                        </aside>

                        <!-- Categories widget-->
                        <aside class="widget widget-categories">
                            <div class="widget-title">
                                <h6>Kategori</h6>
                            </div>
                            <ul>
                                <li><a class="text-decoration-none" href="#">Berita <span class="float-right">3</span></a></li>
                                <li><a class="text-decoration-none" href="#">Artikel <span class="float-right">5</span></a></li>
                                <li><a class="text-decoration-none" href="#">Pengumuman <span class="float-right">2</span></a></li>
                            </ul>
                        </aside>

                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    @forelse ($posts as $post)
                    @php
                        $gambarArray = json_decode($post->gambar, true);
                        $thumbnail = is_array($gambarArray) && count($gambarArray) > 0 
                                   ? asset(trim($gambarArray[0], '\"')) 
                                   : asset('assets/img/placeholder.jpg');
                    @endphp
                    
                    <!-- Post-->
                    <article class="post">
                        <div class="post-preview">
                            <a href="{{ route('users.detail-berita', $post->slug_berita) }}">
                                <img src="{{ $thumbnail }}" alt="{{ $post->judul_berita }}" />
                            </a>
                        </div>
                        <div class="post-wrapper">
                            <div class="post-header">
                                <h2 class="post-title">
                                    <a class="text-decoration-none" href="{{ route('users.detail-berita', $post->slug_berita) }}">
                                        {{ $post->judul_berita }}
                                    </a>
                                </h2>
                                <ul class="post-meta">
                                    <li>{{ \Carbon\Carbon::parse($post->tgl_berita)->translatedFormat('j F Y') }}</li>
                                    <li>By Admin</li>
                                    <li>{{ $post->views }} Views</li>
                                </ul>
                            </div>
                            <div class="post-content">
                                <p>{!! Str::limit(strip_tags($post->isi_berita), 200) !!}</p>
                            </div>
                            <div class="post-more pt-4 align-items-center d-flex">
                                <a href="{{ route('users.detail-berita', $post->slug_berita) }}" class="btn primary-solid-btn">
                                    Baca Selengkapnya <span class="ti-arrow-right"></span>
                                </a>
                            </div>
                        </div>
                    </article>
                    <!-- Post end-->
                    @empty
                    <article class="post">
                        <div class="post-wrapper">
                            <div class="post-header">
                                <h2 class="post-title">Tidak ada berita yang ditemukan</h2>
                            </div>
                            <div class="post-content">
                                <p>Silakan kembali lagi nanti untuk melihat berita terbaru.</p>
                            </div>
                        </div>
                    </article>
                    @endforelse

                    <!-- Page Navigation-->
                    <div class="row">
                        <div class="col-md-12">
                            {{ $posts->links() }}
                        </div>
                    </div>
                    <!-- Page Navigation end-->
                </div>
            </div>
        </div>
    </div>
    <!--blog section end-->
</div>