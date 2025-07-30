<?php
use Livewire\Volt\Component;
use App\Models\AduanSiber;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Services\ChartServices;

new class extends Component {
    use WithPagination;
    
    public string $search = '';
    protected ChartServices $chartServices;
    
    public function mount(): void
    {
        $this->chartServices = app(ChartServices::class);
    }
    
    protected function statusConfig(): array
    {
        return [
            'Diterima'      => ['title' => 'Diterima', 'icon' => 'check-circle', 'color' => 'green'],
            'Dalam Proses'  => ['title' => 'Diproses', 'icon' => 'spinner',      'color' => 'yellow'],
            'Selesai'       => ['title' => 'Selesai',  'icon' => 'circle-check', 'color' => 'blue'],
            'Ditolak'       => ['title' => 'Ditolak',  'icon' => 'x-circle',     'color' => 'red'],
        ];
    }
    
    public function with(): array
    {
        return [
            'aduanStats' => $this->getAduanStats(),
            'aduanPerBulan' => $this->chartServices->getAduanPerBulan(),
            'aplikasiDiadukan' => $this->chartServices->getAplikasiDiadukan(),
            'jenisAduan' => $this->chartServices->getJenisAduan(),
            'getJenisAplikasi' => $this->chartServices->getKategoriAplikasiDiadukan(),
        ];
    }

    protected function getAduanStats(): array
    {
        $counts = DB::table('aduan_siber')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return collect($this->statusConfig())->map(function ($item, $status) use ($counts) {
            return [
                'title' => $item['title'],
                'value' => $counts->get($status, 0)?->total ?? 0,
                'icon'  => $item['icon'],
                'color' => $item['color'],
            ];
        })->values()->all();
    }

    public function recentAduan()
    {
        $query = AduanSiber::query()
            ->with(['aplikasi', 'pelapor'])
            ->select([
                'aduan_siber.id',
                'aplikasi_id',
                'judul_aduan',
                'status',
                'created_at'
            ])
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul_aduan', 'like', '%'.$this->search.'%')
                  ->orWhereHas('aplikasi', fn($q) => $q->where('nama_aplikasi', 'like', '%'.$this->search.'%'))
                  ->orWhereHas('pelapor', fn($q) => $q->where('nama_pengadu', 'like', '%'.$this->search.'%'));
            });
        }

        return $query->paginate(10); 
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
}; ?>


<div class="p-4 space-y-6">
    
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">CSIRT</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('skpd-list') }}">Aduan Siber</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

     <div class="grid grid-cols-1 lg:grid-cols-[38%_62%] gap-6">
        
        <div class="flex flex-col gap-6" wire:ignore>
            
            <div class="grid grid-cols-2 gap-4">
                @foreach($aduanStats as $item)
                <livewire:ui.counter 
                    :title="$item['title']" 
                    :value="$item['value']" 
                    :icon="$item['icon']" 
                    :color="$item['color']" 
                    class="h-full"
                />
                @endforeach
            </div>
            
            
            <div class="bg-white p-4 rounded-xl shadow-md flex-1">
                <livewire:ui.chart.donut-chart 
                    :value="$aplikasiDiadukan" 
                    :height="'300'"
                    :namaChart="'aplikasiDiadukanChart'" 
                    :title="'Aplikasi Diadukan'"
                />
            </div>
        </div>

        
        <div class="flex flex-col gap-6">
            
            <div class="bg-white p-4 rounded-xl shadow-md flex-1">
                <livewire:ui.chart.bar-chart 
                    :value="$aduanPerBulan" 
                    :height="'280'"
                    :namaChart="'aduanPerBulanChart'" 
                    :title="'Aduan 12 Bulan Terakhir'"
                    :color="'#4f46e5'"
                />
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <livewire:ui.chart.donut-chart 
                        :value="$jenisAduan" 
                        :height="'240'"
                        :namaChart="'jenisAduanChart'" 
                        :title="'Jenis Aduan'"
                    />
                </div>
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <livewire:ui.chart.donut-chart 
                        :value="$getJenisAplikasi" 
                        :height="'240'"
                        :namaChart="'jenisAplikasiChart'" 
                        :title="'Jenis Aplikasi'"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Aduan Terbaru</h3>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari aduan..." 
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aplikasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Aduan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($this->recentAduan() as $index => $aduan)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $aduan->aplikasi->nama_aplikasi ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-medium">{{ Str::limit($aduan->judul_aduan, 40) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $aduan->nama_pengadu ?? 'Anonim' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'Diterima' => 'bg-blue-100 text-blue-800',
                                    'Dalam Proses' => 'bg-yellow-100 text-yellow-800',
                                    'Selesai' => 'bg-green-100 text-green-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$aduan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $aduan->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('detail-aduan', $aduan->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada aduan yang ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-right">
                {{ $this->recentAduan()->links() }}
        </div>
    </div>
</div>