<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.guest')]
class extends Component {
    //
}; ?>


 <main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <h1>Dokumen RFC2350 CSIRT Kabupaten Cianjur</h1>
      </div>
    </div><!-- End Page Title -->

    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              {{-- <h5 class="card-title">RFC2350 CSIRT Kabupaten Cianjur</h5> --}}
              <p class="card-text">Dokumen ini berisi spesifikasi dan standar operasional CSIRT Kabupaten Cianjur sesuai dengan standar RFC2350.</p>
            </div>
          </div>
          
          <div class="document-viewer">
            <iframe src="{{ asset('dokumen/RFC2350 CianjurKab_CSIRT.pdf') }}" width="100%" height="800" frameborder="0" allowfullscreen class="border rounded shadow"></iframe>
            
            <div class="mt-3 text-center">
              <a href="{{ asset('dokumen/RFC2350 CianjurKab_CSIRT.pdf') }}" class="btn btn-primary" download>
                <i class="bi bi-download me-2"></i>Unduh Dokumen
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>


