<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use \Livewire\WithPagination;
use App\Models\SKPDModel;


new 
#[Title('Daftar SKPD | Katalog Aplikasi Kabupaten Cianjur')]
class extends Component {

    use WithPagination;

    public $cariPerangkatDaerah = '';
    public $skpd_id = '';

    public function with(): array
    {
        return [
            'kat_skpd'  => DB::table('kategori_skpd')->get(),

            'skpd'      => SKPDModel::select('nama_skpd', 'id', 'email_skpd','email_skpd','no_telp_skpd','website_skpd','skpd_id')
                            ->where('nama_skpd', 'like', '%'.$this->cariPerangkatDaerah.'%')
                            ->where('skpd_id', 'like', '%'.$this->skpd_id.'%')
                            ->oldest()
                            ->paginate(10),
        ];
    }

}; ?>

<div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Katalog Apps </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Daftar Perangkat Daerah</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div >
            <div class=" bg-gray-100">
                <div class="max-w-12xl mx-auto">
    
                    <div class="py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                       <!-- Header dengan Tombol Tambah Pengguna -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800">Daftar Perangkat Daerah</h2>
                            <a 
                                href="{{ route('skpd.create') }}"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-plus-circle mr-2"></i> Pengguna
                            </a>
                        </div>

                        <!-- Filter -->
                        <div class="mb-6 flex flex-wrap gap-4 items-center">
                            <input 
                                type="text" 
                                class="w-full sm:w-1/3 md:w-1/4 lg:w-1/5 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Cari berdasarkan nama instansi..." 
                                wire:model.live.debounce.850ms="cariPerangkatDaerah">
                            
                            <select 
                                class="w-full sm:w-1/3 md:w-1/4 lg:w-1/5 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                        </div>

                    
                       <!-- Tabel Daftar Pengguna -->
                        <div class="overflow-x-auto py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama SKPD</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jml Apps</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telp</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->apps->count() }} Apps</td>

                                            <!-- Permohonan -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-email text-blue-500 text-xs"></i>
                                                    <span class="text-xs">{{ $row->email_skpd }}</span> 
                                                </div>
                                            </td>
                    
                                            <!-- Dokumen -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-phone text-green-500 text-xs"></i>
                                                    <span class="text-xs">{{ $row->no_telp_skpd }}</span>
                                                </div>
                                            </td>

                                            <!-- Dokumen -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-globe text-green-500 text-xs"></i>
                                                    <span class="text-xs">{{ $row->website_skpd }}</span> 
                                                </div>
                                            </td>
                    
                                            
                                            <!-- Aksi -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <!-- Lihat Detail Pengguna -->
                                                <a class="text-blue-600 hover:text-blue-900 mr-2 text-sm" 
                                                        href="{{ route('skpd.edit', $row->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
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
