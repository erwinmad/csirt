<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\ProfilModel;

new 
#[Layout('components.layouts.guest')]
class extends Component {
    public function with(): array
    {
        return [
            'profil' => ProfilModel::first(),
        ];
    }
}; ?>

<div class="main">

        <!--page header section start-->
        <section class="page-header-section ptb-100 gradient-overly-right" style="background: url('assets/img/hero-14.jpg')no-repeat center center / cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7 col-lg-6">
                        <div class="page-header-content text-white">
                            <h1 class="text-white mb-2">Hubungi Kami</h1>
                            <p class="lead">{{ $profil->nama }}</p>
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
                                <li class="list-inline-item breadcrumb-item"><a class="text-decoration-none" href="{{ route('users.kontak-kami') }}">Beranda</a></li>
                                <li class="list-inline-item breadcrumb-item active">Kontak Kami</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <section class="contact-us-promo pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card single-promo-card single-promo-hover text-center mt-4">
                            <div class="card-body py-5">
                                <div class="pb-2">
                                    <span class="ti-mobile icon-sm color-primary"></span>
                                </div>
                                <div>
                                    <h5 class="mb-0">Telepon</h5>
                                    <p class="text-muted mb-0">{{ $profil->telp }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card single-promo-card single-promo-hover text-center mt-4">
                            <div class="card-body py-5">
                                <div class="pb-2">
                                    <span class="ti-location-pin icon-sm color-primary"></span>
                                </div>
                                <div>
                                    <h5 class="mb-0">Alamat</h5>
                                    <p class="text-muted mb-0">{{ $profil->alamat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card single-promo-card single-promo-hover text-center mt-4">
                            <div class="card-body py-5">
                                <div class="pb-2">
                                    <span class="ti-email icon-sm color-primary"></span>
                                </div>
                                <div>
                                    <h5 class="mb-0">Email</h5>
                                    <p class="text-muted mb-0">{{ $profil->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="contact-us-section ptb-100">
            
        </section>

      
    </div>
