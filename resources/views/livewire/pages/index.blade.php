<?php
use function Livewire\Volt\{with};
use App\Services\ChartServices;
use Illuminate\Support\Facades\DB;

with(fn (ChartServices $appService) => [

    'countSkpd' => $appService->getCountSkpd(),
    'countWebsite' => $appService->getCountWebsite(),
    'countApps' =>$appService->getCountApps(),
    'countAduan' => $appService->getCountAduan(),
    'skpdAplikasi' => $appService->getSkpdAplikasi(),
    'jenisAplikasi' => $appService->getJenisesAplikasi(),

]);
?>

<div class="p-4 space-y-6">
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">CSIRT</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('skpd-list') }}">Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    
    <!-- Counter Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <livewire:ui.counter 
            :title="'Aduan'" 
            :value="$countAduan" 
            :icon="'exclamation-triangle'" 
            color="red"
        />
        <livewire:ui.counter 
            :title="'Pentest'" 
            :value="$countSkpd" 
            :icon="'building'" 
            color="blue"
        />
        <livewire:ui.counter 
            :title="'Aplikasi'" 
            :value="$countApps" 
            :icon="'layer-group'" 
            color="indigo"
        />
        <livewire:ui.counter 
            :title="'Website'" 
            :value="$countWebsite" 
            :icon="'globe'" 
            color="green"
        />
        
    </div>

  
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 lg:col-span-2">
            <livewire:ui.chart.bar-chart 
                :value="$skpdAplikasi" 
                :height="'280'" 
                :title="'Aset per SKPD'"
            />
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <livewire:ui.chart.donut-chart 
                :value="$jenisAplikasi" 
                :height="'280'" 
                :namaChart="'jenisChart'" 
                :title="'Jenis Aset'"
            />
        </div>
    </div>

</div>