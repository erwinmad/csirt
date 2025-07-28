<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use \Livewire\WithPagination;
use App\Models\SKPDModel;
use App\Exports\SkpdExport;
use Maatwebsite\Excel\Facades\Excel;

new 
#[Title('Daftar SKPD | Katalog Aplikasi Kabupaten Cianjur')]
class extends Component {

    use WithPagination;

    public $cariPerangkatDaerah = '';
    public $skpd_id = '';
    public $statusFilter = '';

    public function with(): array
    {
        return [
            'kat_skpd'  => DB::table('kategori_skpd')->get(),

            'skpd'      => SKPDModel::select('id', 'nama_skpd', 'website_skpd', 'is_active')
                            ->when($this->cariPerangkatDaerah, function ($query) {
                                return $query->where('nama_skpd', 'like', '%'.$this->cariPerangkatDaerah.'%');
                            })
                            ->when($this->skpd_id, function ($query) {
                                return $query->where('skpd_id', 'like', '%'.$this->skpd_id.'%');
                            })
                            ->when($this->statusFilter !== '', function ($query) {
                                return $query->where('is_active', $this->statusFilter);
                            })
                            ->latest()
                            ->paginate(10),
        ];
    }

    public function toggleStatus($id)
    {
        $skpd = SKPDModel::find($id);
        if ($skpd) {
            $skpd->is_active = !$skpd->is_active;
            $skpd->save();
        }
    }

    public function exportSKPD()
    {
        $fileName = now()->format('Ymd_His') . '_DaftarWebsiteSKPD.xlsx';
        return Excel::download(new SkpdExport, $fileName);
    }

}; ?>

<div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Katalog Apps </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Daftar Website Perangkat Daerah</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div >
            <div class=" bg-gray-100">
                <div class="max-w-12xl mx-auto">
    
                    <div class="py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-md">
                       <!-- Header dengan Tombol Tambah Pengguna -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800">Daftar Website Pemerintah Kabupaten Cianjur</h2>
                        </div>

                        <!-- Filter -->
                        <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
                            <!-- Bagian Kiri (Filter dan Pencarian) -->
                            <div class="flex flex-wrap gap-4 items-center">
                                <!-- Input Pencarian (Lebar Diperbesar) -->
                                <input 
                                    type="text" 
                                    class="w-full sm:w-60 md:w-64 lg:w-110 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Cari berdasarkan nama instansi..." 
                                    wire:model.live.debounce.850ms="cariPerangkatDaerah">
                                
                                <!-- Filter Jenis PD -->
                                <select 
                                    class="w-full sm:w-48 md:w-48 lg:w-48 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    wire:model.live.debounce.850ms="jenisPd">
                                    <option value="">Pilih Jenis PD</option>
                                    <option value="Sekretariat">Sekretariat</option>
                                    <option value="Badan">Badan</option>
                                    <option value="Dinas">Dinas</option>
                                    <option value="Kecamatan">Kecamatan</option>
                                    <option value="Puskesmas">Puskesmas</option>
                                    <option value="Satuan">Satuan</option>
                                    <option value="BLUD">BLUD</option>
                                </select>
                        
                                <!-- Filter Status (Active/Inactive) -->
                                <select 
                                    class="w-full sm:w-48 md:w-48 lg:w-48 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    wire:model.live.debounce.850ms="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        
                            <!-- Bagian Kanan (Tombol Export) -->
                            <div class="flex flex-wrap gap-4 items-center">
                                        <!-- Tombol Export Excel -->
                                <button 
                                    wire:click="exportSKPD"
                                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                                    <i class="fas fa-file-excel mr-2"></i> Excel
                                </button>
                                <!-- Tombol Export PDF -->
                                <button 
                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                                    <i class="fas fa-file-pdf mr-2"></i> PDF
                                </button>
                            </div>
                        </div>

                       <!-- Tabel Daftar Pengguna -->
                        <div class="overflow-x-auto py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama SKPD</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($skpd as $index => $row)
                                        <tr class="border-b">
                                            <!-- No. -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                    
                                            <!-- Nama Pengguna -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->nama_skpd }}</td>
                                           
                                            <!-- Dokumen -->
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-globe text-green-500 text-xs"></i>
                                                    <span class="text-xs">{{ $row->website_skpd }}</span> 
                                                </div>
                                            </td>
                    
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <button 
                                                    wire:click="toggleStatus({{ $row->id }})"
                                                    class="px-2 py-1 text-xs rounded-md {{ $row->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                    {{ $row->is_active ? 'Aktif' : 'Inactive' }}
                                                </button>
                                                
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pengguna yang tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $skpd->links([]) }}
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
