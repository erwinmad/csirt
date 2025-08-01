<?php
use function Livewire\Volt\{with};
use App\Services\ChartServices;
use App\Services\UptimeMonitorService;

with(fn (ChartServices $appService, UptimeMonitorService $uptimeService) => [
    'countSkpd' => $appService->getCountSkpd(),
    'countWebsite' => $appService->getCountWebsite(),
    'countApps' => $appService->getCountApps(),
    'countAduan' => $appService->getCountAduan(),
    'skpdAplikasi' => $appService->getSkpdAplikasi(),
    'jenisAplikasi' => $appService->getJenisesAplikasi(),
    'websiteStatuses' => $uptimeService->getStatus(), // Diubah ke getStatus()
]);
?>
{{-- @dd($websiteUptime); --}}
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
        <!-- Bar Chart (Left Side - Takes 2 cols) -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 lg:col-span-2">
            <livewire:ui.chart.bar-chart 
                :value="$skpdAplikasi" 
                :height="'400'" 
                :title="'Aset per SKPD'"
            />
        </div>
        
        <!-- Right Side (Takes 1 col) -->
        <div class="space-y-6">
            <!-- First Pie Chart -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <livewire:ui.chart.donut-chart 
                    :value="$jenisAplikasi" 
                    :height="'200'" 
                    :namaChart="'jenisChart'" 
                    :title="'Jenis Aset'"
                />
            </div>
            
            <!-- Second Pie Chart -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                {{-- <livewire:ui.chart.donut-chart 
                    :value="$statusAplikasi" 
                    :height="'200'" 
                    :namaChart="'statusChart'" 
                    :title="'Status Aset'"
                /> --}}
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                Website Status Monitor
            </h2>
            <div class="flex items-center text-sm">
                <span class="flex items-center mr-4">
                    <span class="blinking-dot bg-green-500"></span>
                    <span class="ml-1">Operational</span>
                </span>
                <span class="flex items-center">
                    <span class="blinking-dot bg-red-500"></span>
                    <span class="ml-1">Downtime</span>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($websiteStatuses as $website => $statusData)
                @php
                    $status = $statusData['status'] ?? 'down';
                    $checkedAt = $statusData['checked_at'] ?? now()->toDateTimeString();
                @endphp
                <div class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow transition-all duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate flex items-center">
                                <span class="status-dot mr-2 @if($status === 'up') bg-green-500 @else bg-red-500 @endif"></span>
                                {{ $website }}
                            </p>
                            <div class="mt-2 flex items-center text-xs">
                                <span class="inline-block px-2 py-1 rounded 
                                    @if($status === 'up') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $status === 'up' ? 'Online' : 'Offline' }}
                                </span>
                                @if($status === 'up' && isset($statusData['response_time']))
                                <span class="ml-2 text-gray-500">
                                    {{ $statusData['response_time'] }} ms
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="server-light @if($status === 'up') bg-green-400 @else bg-red-400 @endif"></div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-gray-100 flex justify-between items-center text-xs">
                        <span class="text-gray-500">Last checked</span>
                        <span class="font-mono">{{ $checkedAt }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center text-xs text-gray-500">
            <span>Monitoring interval: 15 minutes</span>
            <span>Last full scan: {{ now()->format('d M Y, H:i:s') }}</span>
        </div>
    </div>

<style>
    .server-light {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        box-shadow: 0 0 6px currentColor;
        position: relative;
        animation: pulse 2s infinite;
    }
    
    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .blinking-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: blink 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 0.8; }
        50% { opacity: 1; }
        100% { opacity: 0.8; }
    }
    
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
</style>

</div>