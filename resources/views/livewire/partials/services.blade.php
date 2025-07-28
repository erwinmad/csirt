<?php

use Livewire\Volt\Component;

new class extends Component {

    public $profil;

    public function with(): array
    {
        return [
            'services' => \App\Models\PagesModel::where('kategori_id',2)->orderBy('created_at', 'desc')->get(),
        ];
    }
}; ?>

<section class="our-services ptb-100 gray-light-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="section-heading text-center mb-5 mb-sm-5 mb-md-3 mb-lg-3">
                    <h2>Layanan Kami</h2>
                    <p class="lead">{{ $this->profil->nama }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-plane text-center rounded white-bg shadow-sm p-5 mt-4">
                        {{-- Ikon SVG --}}
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="#0d6efd" viewBox="0 0 16 16">
                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                            </svg>
                        </div>

                        {{-- Konten --}}
                        <div class="service-plane-content">
                            <h3 class="h5">{{ $service->judul_halaman }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->deksripsi_halaman ?? 'ss'), 100) }}</p>
                        </div>

                        {{-- Tautan dan Harga --}}
                        <div class="action-wrap mt-3">
                            <a href="{{ route('users.detail-halaman', $service->slug_halaman) }}" class="btn-link text-decoration-none">
                                Selengkapnya <span class="fas fa-long-arrow-alt-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>Belum ada layanan yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>



