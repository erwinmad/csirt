<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\BeritaModel;
use App\Models\KatBeritaModel;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

new 
#[Layout('components.layouts.guest')]
class extends Component {
    
    public $slug_berita;

    public function mount()
    {
        $post = BeritaModel::where('slug_berita', $this->slug_berita)->firstOrFail();
        
        // Set SEO Meta
        SEOTools::setTitle($post->judul_berita);
        SEOMeta::setDescription(Str::limit(strip_tags($post->isi_berita), 160));
        SEOMeta::addKeyword([$post->kategori->nama_kategori, 'berita terkini', 'informasi terbaru']);
        
        // OpenGraph
        OpenGraph::setTitle($post->judul_berita)
                 ->setDescription(Str::limit(strip_tags($post->isi_berita), 160))
                 ->setType('article')
                 ->setArticle([
                     'published_time' => $post->tgl_berita,
                     'modified_time' => $post->updated_at,
                     'author' => 'Admin',
                     'section' => $post->kategori->nama_kategori,
                     'tag' => [$post->kategori->nama_kategori]
                 ]);
        
        // Twitter Card
        TwitterCard::setTitle($post->judul_berita)
                  ->setDescription(Str::limit(strip_tags($post->isi_berita), 160));
        
        // Jika ada gambar
        $gambarArray = json_decode(stripslashes($post->gambar));
        if (!empty($gambarArray)) {
            $firstImage = asset(trim($gambarArray[0], '\"'));
            OpenGraph::addImage($firstImage);
            TwitterCard::setImage($firstImage);
        }

        BeritaModel::where('slug_berita', $this->slug_berita)
            ->increment('views');
    }

    public function with(): array
    {
        return [
            'slug_berita' => $this->slug_berita,
            'post' => BeritaModel::where('slug_berita', $this->slug_berita)->firstOrFail(),
            'profil' => \App\Models\ProfilModel::first(),
        ];
    }
}; ?>

<div>
    <!--page header section start-->
    <section class="page-header-section ptb-100 gradient-overly-right" style="background: url('{{ asset('assets-v2/img/bg/7.png') }}')no-repeat center center / cover">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-6">
                    <div class="page-header-content text-white">
                        <h1 class="text-white mb-2">{{ $post->judul_berita }}</h1>
                        <p class="lead">{{ $post->kategori->nama_kategori }}</p>
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
                            <li class="list-inline-item breadcrumb-item"><a class="text-decoration-none" href="{{ route('users.index') }}">Beranda</a></li>
                            <li class="list-inline-item breadcrumb-item"><a class="text-decoration-none" href="#">{{ $post->kategori->nama_kategori }}</a></li>
                            <li class="list-inline-item breadcrumb-item active">{{ $post->judul_berita }}</li>
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
                <div class="col-lg-12">
                    <!-- Post-->
                    <article class="post">
                        @php
                            $gambarArray = json_decode(stripslashes($post->gambar));
                            $firstImage = $gambarArray[0] ?? null;
                        @endphp
                        
                        @if($firstImage)
                            <div class="post-preview">
                                <img src="{{ asset(trim($firstImage, '\"')) }}" alt="{{ $post->judul_berita }}" class="img-fluid" />
                            </div>
                        @endif

                        <div class="post-wrapper">
                            <div class="post-header">
                                <h1 class="post-title">{{ $post->judul_berita }}</h1>
                                <ul class="post-meta">
                                    <li>{{ \Carbon\Carbon::parse($post->tgl_berita)->translatedFormat('F j, Y') }}</li>
                                    <li><a class="text-decoration-none" href="#">{{ $post->kategori->nama_kategori }}</a></li>
                                    <li><i class="far fa-eye"></i> {{ $post->views }} Views</li>
                                </ul>
                            </div>
                            <div class="post-content">
                                {!! $post->isi_berita !!}
                            </div>
                            
                            @if(count($gambarArray) > 1)
                                <div class="post-gallery mt-4 row">
                                    @foreach(array_slice($gambarArray, 1) as $img)
                                        <div class="col-md-4 mb-3">
                                            <img src="{{ asset(trim($img, '\"')) }}" alt="{{ $post->judul_berita }}" class="img-fluid rounded">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="post-footer mt-4">
                                <div class="post-tags">
                                    <a class="text-decoration-none" href="#">{{ $post->kategori->nama_kategori }}</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- Post end-->
                </div>
            </div>
        </div>
    </div>
    <!--blog section end-->
</div>