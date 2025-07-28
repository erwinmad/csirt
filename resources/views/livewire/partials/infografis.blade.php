<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
           'posts' => \App\Models\BeritaModel::where([['status_berita',1],['kategori_id',2]])->orderBy('tgl_berita', 'desc')->get(),
        ];
    }
}; ?>

 <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Infografis</h2>
        <p>CSIRT Kabupaten Cianjur</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            @forelse ($posts as $post)
                 <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                    @php
                        $gambarArray = is_array($post->gambar) ? $post->gambar : json_decode($post->gambar, true);
                        $gambarPertama = $gambarArray[0] ?? 'default.jpg';
                    @endphp
                    <img src="{{ asset($gambarPertama) }}" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>{{ $post->judul_berita }}</h4>
                        <a href="{{ asset($gambarPertama) }}" title="{{ $post->judul_berita }}" data-gallery="{{ asset($gambarPertama) }}" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                        <a href="{{ route('users.detail-berita', $post->slug_berita) }}" title="{{ $post->judul_berita }}" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
            </div><!-- End Portfolio Item -->
            @empty
                Tidak ada Infografis untuk saat ini.
            @endforelse
           

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->
