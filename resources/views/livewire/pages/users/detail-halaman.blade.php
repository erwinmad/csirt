<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\PagesModel;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

new 
#[Layout('components.layouts.guest')]
class extends Component {

    public $slug_halaman;

    public function mount()
    {
        $post = PagesModel::where('slug_halaman', $this->slug_halaman)->firstOrFail();
        
        // Set SEO Meta
        SEOTools::setTitle($post->judul_halaman);
        SEOMeta::setDescription(Str::limit(strip_tags($post->deskripsi_halaman), 160));
        
        // Jika ada kategori, tambahkan sebagai keyword
        if($post->kategori) {
            SEOMeta::addKeyword([
                $post->kategori->nama_kategori ?? $post->kategori->judul_halaman,
                'halaman informasi',
                Str::slug($post->judul_halaman, ' ')
            ]);
        }
        
        

        // Canonical URL
        SEOMeta::setCanonical(url()->current());

        // Increment views
        PagesModel::where('slug_halaman', $this->slug_halaman)
            ->increment('views');
    }

    public function with(): array
    {
        return [
            'post' => PagesModel::where('slug_halaman',$this->slug_halaman)->firstOrFail(),
        ];
    }
}; ?>

<div>
    <!--page header section start-->
    <section class="page-header-section ptb-100 gradient-overly-right" style="background: url('assets/img/hero-14.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-6">
                    <div class="page-header-content text-white">
                        <h1 class="text-white mb-2">{{ $post->judul_halaman }}</h1>
                        <p class="lead">{{ $post->kategori->judul_halaman }}</p>
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
                            <li class="list-inline-item breadcrumb-item"><a class="text-decoration-none" href="">{{ $post->kategori->judul_halaman }}</a></li>
                            <li class="list-inline-item breadcrumb-item active">{{ $post->judul_halaman }}</li>
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
                <div class="col-lg-12 col-md-12">
                    <!-- Post-->
                    <article class="post">
                        @php
                            // Handle gambar yang bisa berupa string JSON atau array
                            $gambarArray = is_array($post->gambar) ? $post->gambar : 
                                        (is_string($post->gambar) ? json_decode($post->gambar, true) : []);
                            
                            // Pastikan $gambarArray adalah array
                            $gambarArray = (array) $gambarArray;
                            $firstImage = $gambarArray[0] ?? null;
                        @endphp
                        
                        @if($firstImage && is_string($firstImage))
                            <div class="post-preview">
                                <img src="{{ asset(trim($firstImage, '\"')) }}" alt="{{ $post->judul_halaman }}" class="img-fluid" />
                            </div>
                        @endif

                        <div class="post-wrapper">
                            <div class="post-header">
                                <h1 class="post-title">{{ $post->judul_halaman }}</h1>
                                <ul class="post-meta">
                                    <li>{{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('F j, Y') }}</li>
                                    @if($post->kategori)
                                        <li><a class="text-decoration-none" href="#">{{ $post->kategori->nama_kategori ?? $post->kategori->judul_halaman }}</a></li>
                                    @endif
                                    <li><i class="far fa-eye"></i> {{ $post->views + 1 }} Views</li>
                                </ul>
                            </div>
                            <div class="post-content">
                                {!! $post->deskripsi_halaman !!}
                            </div>
                            
                            @if(count($gambarArray) > 1)
                                <div class="post-gallery mt-4 row">
                                    @foreach(array_slice($gambarArray, 1) as $img)
                                        @if(is_string($img))
                                            <div class="col-md-4 mb-3">
                                                <img src="{{ asset(trim($img, '\"')) }}" alt="{{ $post->judul_halaman }}" class="img-fluid rounded">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            
                            @if($post->kategori)
                                <div class="post-footer mt-4">
                                    <div class="post-tags">
                                        <a class="text-decoration-none" href="#">{{ $post->kategori->nama_kategori ?? $post->kategori->judul_halaman }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                    <!-- Post end-->

                    <!-- You can add comments section here if needed -->
                    
                </div>
               
            </div>
        </div>
    </div>
    <!--blog section end-->
</div>