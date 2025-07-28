<?php
use function Livewire\Volt\{with, state};
use App\Models\AduanSiber;
use App\Models\AduanSiberPelapor;
use App\Models\ProgresAduanSiber;

with([
    'aduan' => fn () => AduanSiber::with(['aplikasi', 'pelapor', 'progres'])->findOrFail(request()->id),
]);

state([
    'status' => '',
    'catatan' => '',
    'showProgressModal' => false,
]);

$updateProgress = function() {
    $this->validate([
        'status' => 'required|string',
        'catatan' => 'nullable|string',
    ]);

    // Create new progress record
    ProgresAduanSiber::create([
        'aduan_siber_id' => $this->aduan->id,
        'status' => $this->status,
        'catatan' => $this->catatan,
    ]);

    // Reset form and close modal
    $this->reset(['status', 'catatan']);
    $this->showProgressModal = false;
};

$markAsResolved = function($aduanId) {
    // Update pelapor status
    AduanSiberPelapor::where('aduan_siber_id', $aduanId)
        ->update(['is_resolved' => true]);

    // Add progress record
    ProgresAduanSiber::create([
        'aduan_siber_id' => $aduanId,
        'status' => 'Selesai',
        'catatan' => 'Aduan telah diselesaikan',
    ]);
};
?>

<div class="p-4 space-y-6">
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">
                <i class="fas fa-shield-alt mr-2"></i>CSIRT
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin-index') }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">
                <i class="fas fa-info-circle mr-2"></i>Detail Aduan
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                Detail Aduan Siber
            </h1>
            <p class="text-gray-600 flex items-center gap-1">
                <i class="fas fa-hashtag text-gray-400"></i>
                {{ $aduan->id }}
            </p>
        </div>
        <div class="flex gap-3">
            <span class="px-3 py-1 rounded-full text-sm font-medium flex items-center gap-1
                {{ $aduan->pelapor->is_resolved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                <i class="fas {{ $aduan->pelapor->is_resolved ? 'fa-check-circle' : 'fa-spinner' }}"></i>
                {{ $aduan->pelapor->is_resolved ? 'Selesai' : 'Dalam Proses' }}
            </span>
            <button class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium flex items-center gap-1">
                <i class="fas fa-print"></i>
                Cetak
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Aduan Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Aduan Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-alt text-blue-500"></i>
                    Informasi Aduan
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            {{ $aduan->judul_aduan }}
                        </h3>
                        <p class="text-gray-600 mt-1 flex items-center gap-2">
                            <i class="fas fa-window-maximize text-gray-400"></i>
                            Aplikasi: <span class="font-medium">{{ $aduan->aplikasi->nama_aplikasi }}</span>
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-gray-400"></i>
                            Deskripsi Aduan:
                        </h4>
                        <p class="text-gray-600 mt-1 whitespace-pre-line pl-6">{{ $aduan->deskripsi_aduan }}</p>
                    </div>
                    
                    @if($aduan->foto_aduan)
                    <div>
                        <h4 class="font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-camera text-gray-400"></i>
                            Bukti Foto:
                        </h4>
                        <img 
                            src="{{ asset('storage/' . $aduan->foto_aduan) }}" 
                            alt="Bukti aduan"
                            class="mt-2 rounded-lg border border-gray-200 max-h-64"
                        >
                    </div>
                    @endif
                </div>
            </div>

            <!-- Progress Timeline -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-purple-500"></i>
                    Riwayat Progres
                </h2>
                
                <div class="flow-root">
                    <ul class="-mb-8">
                        @forelse($aduan->progres as $progress)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-{{ 
                                                $progress->status === 'Diterima' ? 'check' : 
                                                ($progress->status === 'Diproses' ? 'cog' : 
                                                ($progress->status === 'Selesai' ? 'check-circle' : 'info-circle'))
                                            }} text-white text-xs"></i>
                                        </span>
                                    </div>
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-800">
                                                Status diubah menjadi <span class="font-medium">{{ $progress->status }}</span>
                                                @if($progress->catatan)
                                                <span class="text-gray-600 block mt-1">{{ $progress->catatan }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                            <time datetime="{{ $progress->created_at }}">{{ $progress->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-gray-500 text-sm flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Belum ada riwayat progres
                        </li>
                        @endforelse
                        
                        <!-- Current Status -->
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-{{ $aduan->pelapor->is_resolved ? 'green' : 'yellow' }}-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-{{ $aduan->pelapor->is_resolved ? 'check-circle' : 'hourglass-half' }} text-white text-xs"></i>
                                        </span>
                                    </div>
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-800">
                                                Status saat ini: <span class="font-medium">{{ $aduan->pelapor->is_resolved ? 'Selesai' : 'Dalam Proses' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column - Pelapor & Actions -->
        <div class="space-y-6">
            <!-- Pelapor Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-tie text-teal-500"></i>
                    Informasi Pelapor
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-400"></i>
                            Nama Lengkap
                        </h4>
                        <p class="text-gray-800 pl-6">{{ $aduan->pelapor->nama_pengadu }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-400"></i>
                            Email
                        </h4>
                        <p class="text-gray-800 pl-6">{{ $aduan->pelapor->email_pengadu ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-phone-alt text-gray-400"></i>
                            Nomor Telepon
                        </h4>
                        <p class="text-gray-800 pl-6">{{ $aduan->pelapor->no_telp_pengadu ?? '-' }}</p>
                    </div>
                    
                    @if($aduan->pelapor->tanggapan)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-comment-dots text-gray-400"></i>
                            Tanggapan
                        </h4>
                        <p class="text-gray-800 whitespace-pre-line pl-6">{{ $aduan->pelapor->tanggapan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-tasks text-red-500"></i>
                    Tindakan
                </h2>
                
                <div class="space-y-4">
                    @if(!$aduan->pelapor->is_resolved)
                    <button 
                        wire:click="markAsResolved({{ $aduan->id }})"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                    >
                        <i class="fas fa-check-circle"></i>
                        Tandai Selesai
                    </button>
                    @endif
                    
                    <button 
                        wire:click="$toggle('showProgressModal')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        <i class="fas fa-edit"></i>
                        Update Progres
                    </button>
                    
                    <button 
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
                    >
                        <i class="fas fa-envelope"></i>
                        Hubungi Pelapor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Progress Modal -->
    <x-modal wire:model="showProgressModal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 py-4">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-edit text-blue-500"></i>
                        Update Progres Aduan
                    </h3>
                    <button wire:click="$set('showProgressModal', false)" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-tag mr-2 text-gray-500"></i>
                        Status
                    </label>
                    <select 
                        wire:model="status"
                        id="status"
                        class="mt-1 block w-full pl-10 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                    >
                        <option value="">Pilih Status</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Ditunda">Ditunda</option>
                    </select>
                </div>
                
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-sticky-note mr-2 text-gray-500"></i>
                        Catatan
                    </label>
                    <textarea 
                        wire:model="catatan"
                        id="catatan"
                        rows="3"
                        class="mt-1 block w-full pl-10 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        placeholder="Tambahkan catatan progres..."
                    ></textarea>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                <button
                    wire:click="updateProgress"
                    type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
                <button
                    wire:click="$set('showProgressModal', false)"
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
            </div>
        </div>
    </x-modal>
</div>