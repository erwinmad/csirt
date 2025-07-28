<?php
use Livewire\Volt\Component;
use App\Models\AduanSiber;

new class extends Component {
   
    public function with()
    {
        return [
            'recentAduan' => DB::table('aduan_siber')
                            ->join('daftar_aplikasi', 'aduan_siber.aplikasi_id', '=', 'daftar_aplikasi.id')
                            ->leftJoin('aduan_siber_pelapor', 'aduan_siber.id', '=', 'aduan_siber_pelapor.aduan_siber_id')
                            ->select(
                                'aduan_siber.id',
                                'daftar_aplikasi.nama_aplikasi',
                                'aduan_siber.judul_aduan',
                                'aduan_siber_pelapor.nama_pengadu',
                                'aduan_siber_pelapor.is_resolved',
                                'aduan_siber.created_at'
                            )
                            ->orderBy('aduan_siber.created_at', 'desc')
                            ->take(5)
                            ->get(),
        ];
    }

}; ?>


<div class="p-4 space-y-6">
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">CSIRT</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('skpd-list') }}">Aduan Siber</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <livewire:ui.counter 
            :title="'Diterima'" 
            :value="1" 
            :icon="'check-circle'" 
            color="green"
        />
        <livewire:ui.counter 
            :title="'Diproses'" 
            :value="2"
            :icon="'spinner'" 
            color="yellow"
        />
        <livewire:ui.counter 
            :title="'Selesai'" 
            :value="3"
            :icon="'circle-check'" 
            color="blue"
        />
    </div>

     <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Aduan Terbaru</h3>
            <span class="text-sm text-gray-500">5 aduan terakhir</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aplikasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Aduan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentAduan as $aduan)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $aduan->nama_aplikasi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-medium">{{ Str::limit($aduan->judul_aduan, 40) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $aduan->nama_pengadu }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $aduan->is_resolved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $aduan->is_resolved ? 'Selesai' : 'Proses' }}
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
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada aduan terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-right">
            <a href="{{ route('admin-index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                Lihat Semua Aduan →
            </a>
        </div>
    </div>

</div>