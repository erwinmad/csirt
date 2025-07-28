<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

new 
#[Layout('components.layouts.guest')]
class extends Component {
    public function with(): array
    {
        return [
            'profil'      => DB::table('profil')->first(),
        ];
    }
}; ?>

<div>

    <div class="main">

        <!--hero section start-->
        <livewire:partials.carousel :profil="$profil" />
        
        <livewire:partials.services :profil="$profil" />
        
        <livewire:partials.recent-posts :profil="$profil" />
        
        





        <!--services section end-->

        <!--call to action section start-->
        <section class="call-to-action ptb-100 gradient-overlay" style="background: url('assets/img/hero-bg-4.jpg')no-repeat center center / cover">
            <div class="container">
                <div class="position-relative">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-9">
                            <div class="call-to-action-content text-white text-center">
                                <h2 class="text-white">Aduan Siber</h2>
                                <p class="lead mb-0">Laporkan Ancaman Siber, Wujudkan Cianjur yang Lebih Aman!</p>
                                <p class="lead mb-0">&nbsp;</p>
                                <div class="action-btns d-flex align-items-center justify-content-center gap-3">
                                    <a href="#" class="btn solid-white-btn mr-3">Buat Aduan</a>
                                    <a href="#" class="btn outline-white-btn">Email Kami</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <livewire:partials.teams :profil="$profil" /> 

    </div>

  

</div>

