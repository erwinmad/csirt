<?php
use function Livewire\Volt\{state, with, rules};
use App\Models\AduanSiber;
use App\Models\AduanSiberPelapor;
use App\Models\ProgresAduanSiber;

with([
    'aduan' => fn () => AduanSiber::with(['aplikasi', 'pelapor', 'progres'])
        ->findOrFail(request()->id),
]);

state([
    'id' => fn() => request()->id,
    'status' => '',
    'catatan' => '',
    'showDrawer' => false
]);

rules([
    'status' => 'required|string',
    'catatan' => 'nullable|string',
]);

$openDrawer = function() {
    $this->showDrawer = true;
};

$closeDrawer = function() {
    $this->showDrawer = false;
    $this->reset(['status', 'catatan']);
};

$updateProgress = function() {
    $this->validate();
    
    ProgresAduanSiber::create([
        'aduan_siber_id' => $this->aduan->id,
        'status' => $this->status,
        'catatan' => $this->catatan,
    ]);

    $this->closeDrawer();
    $this->aduan->refresh();
    $this->dispatch('progressUpdated');
};

$markAsResolved = function() {
    AduanSiberPelapor::where('aduan_siber_id', $this->id)
        ->update(['is_resolved' => true]);

    ProgresAduanSiber::create([
        'aduan_siber_id' => $this->id,
        'status' => 'Selesai',
        'catatan' => 'Aduan telah diselesaikan',
    ]);
    
    $this->aduan->refresh();
    $this->dispatch('aduanResolved');
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

    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="relative h-48 bg-gradient-to-r from-yellow-500 to-orange-600 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10 text-center p-6">
                <h1 class="text-3xl font-bold text-white">{{ $aduan->aplikasi->nama_aplikasi }}</h1>
                <p class="text-white mt-2">Detail Aduan Siber</p>
                <div class="flex justify-center mt-4 space-x-3">
                    <span class="px-4 py-1 text-sm font-medium rounded-full 
                        {{ $aduan->pelapor->is_resolved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $aduan->pelapor->is_resolved ? 'Selesai' : 'Dalam Proses' }}
                    </span>
                    <span class="px-4 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                        ID: {{ $aduan->id }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-6">
            <!-- Left Column (6 grid) -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Aduan Details Card -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-file-alt text-blue-500 mr-2"></i> Detail Aduan
                        </h2>
                        {{-- @if(!$aduan->pelapor->is_resolved) --}}
                        <button wire:click="openDrawer" 
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-1"></i> Update
                        </button>
                        {{-- @endif --}}
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $aduan->judul_aduan }}</h3>
                            <p class="text-gray-500 text-sm mt-1">
                                Dibuat: {{ $aduan->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-align-left text-gray-400"></i>
                                Deskripsi:
                            </h4>
                            <p class="text-gray-600 mt-1 whitespace-pre-line pl-6">{{ $aduan->deskripsi_aduan }}</p>
                        </div>
                        @if($aduan->foto_aduan)
                        <div>
                            <h4 class="font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-camera text-gray-400"></i>
                                Bukti Foto:
                            </h4>
                            <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" 
                                 alt="Bukti aduan"
                                 class="mt-2 rounded-lg border border-gray-200 max-h-64 cursor-pointer hover:opacity-90 transition"
                                 onclick="window.open('{{ asset('storage/' . $aduan->foto_aduan) }}', '_blank')">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Progress History Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history text-purple-500 mr-2"></i> Riwayat Progres
                        </h2>
                        <span class="text-sm text-gray-500">
                            Total: {{ $aduan->progres->count() }} update
                        </span>
                    </div>
                    <div class="p-6">
                        <ul class="-mb-8">
                            @forelse($aduan->progres->sortByDesc('created_at') as $progress)
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
                                                <time datetime="{{ $progress->created_at }}">{{ $progress->created_at->format('d M H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="text-gray-500 text-sm py-4">
                                Belum ada riwayat progres
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column (6 grid) -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Aplikasi Info Card -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-window-maximize text-purple-500 mr-2"></i> Aplikasi Terkait
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Nama Aplikasi</span>
                            <span class="font-medium">{{ $aduan->aplikasi->nama_aplikasi }}</span>
                        </div>
                        @if($aduan->aplikasi->url_aplikasi)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">URL Aplikasi</span>
                            <a href="{{ $aduan->aplikasi->url_aplikasi }}" target="_blank" 
                               class="text-blue-600 hover:underline">
                                <i class="fas fa-external-link-alt"></i> Kunjungi
                            </a>
                        </div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Status Aplikasi</span>
                            <span class="font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $aduan->aplikasi->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $aduan->aplikasi->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Tanggal Dibuat</span>
                            <span class="font-medium">{{ $aduan->aplikasi->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pelapor Info Card -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-tie text-teal-500 mr-2"></i> Informasi Pelapor
                        </h2>
                        {{-- @if(!$aduan->pelapor->is_resolved) --}}
                        <button wire:click="markAsResolved" 
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-check-circle mr-1"></i> Selesaikan
                        </button>
                        {{-- @endif --}}
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Nama Lengkap</span>
                            <span class="font-medium">{{ $aduan->pelapor->nama_pengadu }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Email</span>
                            <span class="font-medium">{{ $aduan->pelapor->email_pengadu ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">Nomor Telepon</span>
                            <span class="font-medium">{{ $aduan->pelapor->no_telp_pengadu ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">URL Aduan</span>
                            <span class="font-medium">
                                @if($aduan->url_aduan)
                                <a href="{{ $aduan->url_aduan }}" target="_blank" class="text-blue-600 hover:underline">
                                    <i class="fas fa-external-link-alt"></i> Link
                                </a>
                                @else
                                -
                                @endif
                            </span>
                        </div>
                        @if($aduan->pelapor->tanggapan)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggapan</h3>
                            <p class="text-gray-800 whitespace-pre-line bg-gray-50 p-3 rounded-md">{{ $aduan->pelapor->tanggapan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Terakhir diperbarui: {{ $aduan->updated_at->format('d M Y H:i') }}
            </div>
            <div class="flex space-x-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    <!-- Drawer for Progress Update -->
    <div class="fixed inset-0 overflow-hidden z-50" x-show="$wire.showDrawer" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 x-on:click="$wire.closeDrawer()"
                 x-transition:enter="ease-in-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="relative w-screen max-w-md">
                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Update Progres Aduan
                                </h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button x-on:click="$wire.closeDrawer()" 
                                            class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <span class="sr-only">Close panel</span>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <form wire:submit.prevent="updateProgress" class="space-y-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="status" id="status" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Pilih Status</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Diproses">Diproses</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                    @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea wire:model="catatan" id="catatan" rows="4" 
                                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>
                                
                                <div class="flex justify-end space-x-3 border-t border-gray-200 pt-4">
                                    <button type="button" 
                                            x-on:click="$wire.closeDrawer()"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-times mr-2"></i> Batal
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-save mr-2"></i> Simpan Progres
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('progressUpdated', () => {
            const drawer = document.querySelector('[x-show="$wire.showDrawer"]');
            if (drawer) {
                drawer.style.display = 'none';
            }
            // Show success notification
            Toastify({
                text: "Progres aduan berhasil diperbarui",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#10B981",
                stopOnFocus: true,
            }).showToast();
        });

        Livewire.on('aduanResolved', () => {
            // Show success notification
            Toastify({
                text: "Aduan berhasil ditandai sebagai selesai",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#10B981",
                stopOnFocus: true,
            }).showToast();
        });
    });
</script>
@endpush