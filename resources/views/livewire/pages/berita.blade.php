<?php

use Livewire\Volt\Component;
use App\Models\BeritaModel;

new class extends Component {

    public $confirmingDeletion = null;

    public function with()
    {
        return [
            'beritas' => BeritaModel::with('kategori') // Hanya load kategori
                        // ->when($this->search, function($query) {
                        //     $query->where('judul_berita', 'like', '%'.$this->search.'%');
                        // })
                        // ->when($this->kategori_id, function($query) {
                        //     $query->where('kategori_id', $this->kategori_id);
                        // })
                        ->latest()
                        ->paginate(10),
        ];
    }

    public function confirmDelete($id): void
    {
        $this->confirmingDeletion = $id;
    }

    public function toggleActive($id): void
    {
        try {
            $berita = BeritaModel::findOrFail($id);
            $berita->status_berita = !$berita->status_berita;
            $berita->save();
            
            $status = $berita->status_berita ? 'diaktifkan' : 'dinonaktifkan';
            session()->flash('message', 'Berita "'.$berita->judul_berita.'" berhasil '.$status);
            session()->flash('message_type', 'success');
            
        } catch (\Exception $e) {
            session()->flash('message', 'Gagal mengubah status berita: '.$e->getMessage());
            session()->flash('message_type', 'error');
        }
    }

    public function deletePage($id): void
    {
        try {
            $berita = BeritaModel::findOrFail($id);
            $judul = $berita->judul_berita; // Ganti dengan field yang sesuai
            $berita->delete();
            
            session()->flash('message', 'Berita "'.$judul.'" berhasil dihapus');
            session()->flash('message_type', 'success');
            
        } catch (\Exception $e) {
            session()->flash('message', 'Gagal menghapus berita : '.$e->getMessage());
            session()->flash('message_type', 'error');
        }
        
        $this->confirmingDeletion = null;
        $this->redirect(route('berita-list'), navigate: true);
    }
    
}; ?>

<div>


    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">CSIRT </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Halaman</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div >
            <div class=" bg-gray-100">
                <div class="max-w-12xl mx-auto">

                    @if(session()->has('message'))
                        <div @class([
                            'mb-4 p-4 rounded-md border flex items-start justify-between gap-4',
                            'bg-green-100 text-green-800 border-green-200' => session('message_type') === 'success',
                            'bg-red-100 text-red-800 border-red-200' => session('message_type') === 'error',
                            'bg-blue-100 text-blue-800 border-blue-200' => !in_array(session('message_type'), ['success', 'error'])
                        ])>
                            <div class="flex items-start gap-3">
                                @if(session('message_type') === 'success')
                                    <svg class="w-6 h-6 text-green-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif(session('message_type') === 'error')
                                    <svg class="w-6 h-6 text-red-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 18h.01" />
                                    </svg>
                                @endif
                                <span class="text-sm">{{ session('message') }}</span>
                            </div>
                            <button @click="this.parentElement.remove()" class="text-gray-500 hover:text-gray-700 text-xl leading-none">
                                &times;
                            </button>
                        </div>
                    @endif
                
    
                    <div class="py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                       <!-- Header dengan Tombol Tambah Pengguna -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800">Daftar Berita</h2>
                            <a 
                                href="{{ route('berita-list.tambah') }}"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-plus-circle mr-2"></i> Berita
                            </a>
                        </div>

                       <!-- Tabel Daftar Pengguna -->
                        <div class="overflow-x-auto py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($beritas as $index => $row)
                                        <tr class="border-b">
                                            <!-- No. -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                    
                                            <!-- Nama Pengguna -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->judul_berita }}</td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->kategori->nama_kategori }}</td>

                                            <!-- Permohonan -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-clock text-blue-500 text-xs"></i>
                                                    <span class="text-xs">
                                                        {{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y') }}
                                                    </span> 
                                                </div>
                                            </td>


                                            <!-- Permohonan -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-email text-blue-500 text-xs"></i>
                                                    <span class="text-xs">{{ $row->views }} Kali</span> 
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <button wire:click="toggleActive({{ $row->id }})" 
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($row->status_berita) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                                    @if($row->status_berita)
                                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        Aktif
                                                    @else
                                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        Nonaktif
                                                    @endif
                                                </button>
                                            </td>
                    
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <!-- Lihat Detail Pengguna -->
                                                <a class="text-blue-600 hover:text-blue-900 mr-2 text-sm" 
                                                        href="{{ route('berita-list.edit', $row->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Delete Button -->
                                                <button wire:click="confirmDelete({{ $row->id }})" 
                                                        class="text-red-600 hover:text-red-900 text-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Confirmation Modal -->
                                                @if($confirmingDeletion === $row->id)
                                                    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                                                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
                                                            <h3 class="text-lg font-medium mb-4">Konfirmasi Penghapusan</h3>
                                                            <p class="mb-6">Apakah Anda yakin ingin menghapus halaman ini?</p>
                                                            <div class="flex justify-end space-x-3">
                                                                <button wire:click="$set('confirmingDeletion', null)" 
                                                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                                    Batal
                                                                </button>
                                                                <button wire:click="deletePage({{ $row->id }})" 
                                                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                                    Hapus
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500"></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $beritas->links([]) }}
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
