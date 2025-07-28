<?php
 
use function Livewire\Volt\{with,state,layout,title};
use App\Services\ChartServices;
use Illuminate\Support\Facades\DB;
    
    layout('components.layouts.guest');
    title('Katalog Aplikasi');

    with(fn (ChartServices $appService) => [
        'countSkpd' => $appService->getCountSkpd(),
        'countApps' => $appService->getCountApps(),
        'countWebsite' => $appService->getCountWebsite(),
        'skpdAplikasi' => $appService->getSkpdAplikasi(),
        'jenisAplikasi' => $appService->getJenisAplikasi(),
        'kategoriAplikasi' => $appService->getKategoriAplikasi(),
        'bahasaAplikasi' => $appService->getBahasaAplikasi(),
        'databaseAplikasi' => $appService->getDatabaseAplikasi(),
        'frameworkAplikasi' => $appService->getFrameworkAplikasi(),
        'pembuatAplikasi' => $appService->getPembuatAplikasi(),
        'platformAplikasi' => $appService->getPlatformAplikasi(),
        'is_featured'  => DB::table('daftar_aplikasi')->where('is_featured', 1)
                        ->select('id', 'nama_aplikasi', 'uraian_aplikasi','url_aplikasi')
                        ->get(),
    ]);
 
?>

<div>
    <div class="row">
        <div class="col-xl-12 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between flex-wrap">
                <div>
                  <div class="card-title mb-0">Selamat Datang di</div>
                  <h3 class="font-weight-bold mb-0">Katalog Aplikasi</h3>
                </div>
              </div>
              <p class="text-muted font-13 mt-2 mt-sm-0"> Pemerintah Kabupaten Cianjur</a>
              </p>
              <div class="card-body">
                <div class="row">
                    
                    @foreach ($is_featured as $row)
                    <div class="col-md-2 stretch-card grid-margin">
                      <div class="card bg-primary text-white" data-toggle="tooltip" title="{{ $row->uraian_aplikasi }}">
                        <div class="card-body text-center">
                            <i class="mdi mdi-slack mdi-48px"></i>
                            <a href="{{ $row->url_aplikasi }}">
                              <h5 class="mt-2">{{ $row->nama_aplikasi }}</h5>
                            </a>
                        </div>
                      </div>
                    </div>
                    @endforeach
              
                </div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="flot-chart-wrapper">
                <livewire:ui.chart.bar-chart :value="$skpdAplikasi" :height="'250'" :title="'Aplikasi per SKPD'"/>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="flot-chart-wrapper">
                <livewire:ui.chart.donut-chart :value="$kategoriAplikasi" :height="'250'" :namaChart="'kategoriChart'" :title="'Kategori Aplikasi'"/>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- chart row starts here -->
      <div class="row">
        <div class="col-sm-3 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="line-chart-wrapper">
                <livewire:ui.chart.donut-chart :value="$platformAplikasi" :height="'240'" :namaChart="'platformChart'" :title="'Platform Aplikasi'"/>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="line-chart-wrapper">
                <livewire:ui.chart.donut-chart :value="$pembuatAplikasi" :height="'240'" :namaChart="'pembuatChart'" :title="'Pengembangin Aplikasi'"/>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="line-chart-wrapper">
                  <livewire:ui.chart.column-chart :value="$jenisAplikasi" :height="'240'" :title="'Kategori Aplikasi berdasarkan Fungsi'"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      <!-- table row starts here -->
      <div class="row">
        <livewire:ui.tabel-aplikasi/>
      </div>
      
    </div>

    
</div>

