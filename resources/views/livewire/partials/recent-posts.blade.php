<?php

use Livewire\Volt\Component;

new class extends Component {

    public $profil;
    public function with(): array
    {
        return [
            'posts' => \App\Models\BeritaModel::where([['status_berita',1],['kategori_id',1]])->orderBy('tgl_berita', 'desc')->get(),
        ];
    }

}; ?>

<section class="our-blog-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="section-heading mb-5">
                    <h2>Berita Seputar {{ $this->profil->nama }}</h2>
                    <p>
                        Dapatkan berita terbaru dan informasi terkini dari {{ $this->profil->nama }}.
                    </p>
                </div>
            </div>
            <div class="col-md-4 text-md-end align-self-end">
                <a class="btn btn-primary" href="{{ route('users.berita') }}">Lihat Semua Berita</a>
            </div>
        </div>
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4">
                    <div class="single-blog-card card border-0 shadow-sm">
                        @php
                            $gambarArray = is_array($post->gambar) ? $post->gambar : json_decode($post->gambar, true);
                            $gambarPertama = $gambarArray[0] ?? 'default.jpg';
                        @endphp
                        <span class="category position-absolute badge badge-pill badge-primary">{{ $post->kategori->nama_kategori }}</span>
                        <img src="{{ asset($gambarPertama) }}" class="card-img-top position-relative" alt="{{ $post->judul_berita }}">
                        <div class="card-body">
                            <div class="post-meta mb-2">
                                <ul class="list-inline meta-list">
                                    <li class="list-inline-item">{{ \Carbon\Carbon::parse($post->tgl_berita)->translatedFormat('j M Y') }}</li>
                                    <li class="list-inline-item">By Admin</li>
                                </ul>
                            </div>
                            <h3 class="h5 card-title"><a href="{{ route('users.detail-berita', $post->slug_berita) }}">{{ $post->judul_berita }}</a></h3>
                            <p class="card-text">{{ Str::limit($post->isi_berita), 100 }}</p>
                            <a href="{{ route('users.detail-berita', $post->slug_berita) }}" class="detail-link">
                                Baca Selengkapnya <span class="ti-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>Tidak ada berita terbaru saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- If you want to add pagination later -->
        <!--
        <div class="row">
            <div class="col-md-12">
                <nav class="custom-pagination-nav mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#"><span class="ti-angle-left"></span></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><span class="ti-angle-right"></span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        -->
    </div>
</section>