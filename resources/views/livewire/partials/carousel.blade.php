<?php

use Livewire\Volt\Component;

new class extends Component {
    public $profil;
    public function with(): array
    {
        return [
            'teams' => DB::table('team_kami')
                ->orderBy('created_at', 'asc')
                ->get(),
        ];
    }
}; ?>

<section class="hero-equal-height ptb-100 gradient-overlay gradient-bg" style="background: url('{{ asset('assets-v2/img/banner-3/5.png') }}') no-repeat center center / cover">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 col-12">
                <div class="hero-content-wrap text-white position-relative">
                    <h6 class="text-white mb-3 wow animated fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.3s">Pemerintah Kabupaten Cianjur</h6>
                    <h1 class="text-white wow animated fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.4s">{{ $profil->nama }}</h1>
                    <p class="lead wow animated fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.5s">
                        CSIRT Kabupaten Cianjur adalah tim tanggap insiden keamanan siber yang bertugas menangani, menganalisis, dan merespons ancaman serta insiden siber di lingkungan Pemerintah Kabupaten Cianjur secara cepat dan terkoordinasi meliputi domain *.cianjurkab.go.id
                    </p>
                    
                    <!-- Optional: Add a button if needed -->
                    <div class="mt-4 wow animated fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.6s">
                        <a href="{{ route('users.aduan') }}" class="btn btn-primary btn-hover">
                            Buat Aduan Siber <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="animation-image-wrap wow animated fadeInRight" data-wow-duration="1.5s" data-wow-delay="0.3s">
                    <img src="{{ asset('images/cianjurkab-csirt.png') }}" alt="CSIRT Cianjur" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
</section>