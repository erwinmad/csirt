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

<section class="our-team-section ptb-100 custom-dot dot-bottom-center position-relative  gray-light-bg">
    <div class="owl-dots z-2"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8">
                <div class="section-heading text-center mb-5">
                    {{-- <h6 class="sub-title">TIM KAMI</h6> --}}
                    <h2 class="title">Team <span>CSIRT Kabupaten Cianjur</span></h2>
                    <p>Tim profesional yang siap melindungi dunia digital Kabupaten Cianjur dari berbagai ancaman siber.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @if($teams->count() > 0)
                <div class="team-member-carousel swiper">
                    <div class="swiper-wrapper">
                        @foreach ($teams as $team)
                        <div class="swiper-slide">
                            <div class="item">
                                <div class="staff-member">
                                    <div class="card text-center">
                                        <img src="{{ asset($team->foto) }}" alt="{{ $team->nama }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="teacher mb-0">{{ $team->nama }}</h5>
                                            <span>{{ $team->jabatan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-users-slash fa-3x mb-3"></i>
                        <p>Belum ada data tim yang ditambahkan.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- @push('scripts')
@if($teams->count() > 0)
<script>
    // Initialize Swiper when component mounts
    document.addEventListener('livewire:init', () => {
        new Swiper('.team-member-carousel', {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.owl-dots',
                clickable: true
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                }
            }
        });
    });
</script>
@endif
@endpush --}}