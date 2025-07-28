<?php

use Livewire\Volt\Component;
use Carbon\Carbon;


new class extends Component {
    public function with(): array
    {
        return [
            'profiles' => DB::table('halaman')
                ->where('kategori_id', 1) 
                ->orderBy('created_at', 'asc')
                ->get(),

            'services' => DB::table('halaman')
                ->where('kategori_id', 2) 
                ->orderBy('created_at', 'asc')
                ->get(),

            'profil' => DB::table('profil')->first(),

            'beritas' => DB::table('berita')
                ->where('status_berita', 1)
                ->orderBy('views', 'desc')
                ->get(),
        ];
    }
}; ?>
<footer class="footer-section">
    <!--footer top start-->
    <div class="footer-top gradient-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-nav-wrap text-white">
                        <h4 class="text-white">CSIRT KABUPATEN CIANJUR</h4>
                        <div class="widget widget_about">
                            <div class="thumb mb-3">
                                <img src="{{ asset($profil->foto_path ?? '') }}" alt="{{ $profil->nama }}" class="img-fluid rounded" style="max-height: 80px;">
                            </div>
                            <p class="text-white-50">{{ $profil->alamat }}</p>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> {{ $profil->telp }}</li>
                                <li class="mb-2"><i class="fas fa-envelope me-2"></i> {{ $profil->email }}</li>
                                <li class="mb-2"><i class="fas fa-globe me-2"></i> {{ $profil->website }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-nav-wrap text-white">
                        <h4 class="text-white">LAYANAN</h4>
                        <ul class="nav flex-column">
                            @forelse ($services as $service)
                                <li class="nav-item">
                                    <a class="nav-link ps-0" href="{{ route('users.detail-halaman', $service->slug_halaman) }}">
                                        <i class="fas fa-arrow-right me-2"></i>{{ $service->judul_halaman }}
                                    </a>
                                </li>
                            @empty
                                <li class="nav-item">
                                    <a class="nav-link ps-0" href="#">
                                        <i class="fas fa-arrow-right me-2"></i>Belum ada layanan
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="footer-nav-wrap text-white">
                        <h4 class="text-white">LOKASI KAMI</h4>
                        <div class="ratio ratio-16x9">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.4737540219835!2d107.1211027!3d-6.833660900000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6853ee75deae2f%3A0x5759a53e3b29f411!2sDinas%20Komunikasi%2C%20Informatika%2C%20Persandian%20Kab.Cianjur!5e0!3m2!1sen!2sid!4v1753541516627!5m2!1sen!2sid" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="rounded">
                            </iframe>
                        </div>
                        <div class="mt-3">
                            <a href="https://maps.google.com/?q={{ urlencode($profil->alamat) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-light">
                               <i class="fas fa-map-marker-alt me-2"></i> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer top end-->

    <!--footer copyright start-->
    <div class="footer-bottom gray-light-bg py-3">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-6">
                    <p class="copyright-text pb-0 mb-0">Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh Diskominfo Cianjur</p>
                </div>
            </div>
        </div>
    </div>
    <!--footer copyright end-->
</footer>