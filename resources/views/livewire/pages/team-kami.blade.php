<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

new class extends Component {
    public $cariNama = '';
    public $confirmingDelete = false;
    
    #[On('team-updated')]
    public function with(): array
    {
        return [
            'teams' => DB::table('team_kami')
                      ->when($this->cariNama, fn($query) => $query->where('nama', 'like', '%'.$this->cariNama.'%'))
                      ->orderBy('created_at', 'desc')
                      ->get(),
        ];
    }

    public function hapusAnggota($id)
    {
       
        $team = DB::table('team_kami')->where('id', $id)->first();
        
        if ($team) {
            if ($team->foto) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $team->foto);
            }
            
            DB::table('team_kami')->where('id', $id)->delete();
            
            $this->confirmingDelete = false;
            
            session()->flash('message', 'Anggota team berhasil dihapus!');

            $this->dispatch('team-updated');
        }
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Katalog Apps</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Team Kami</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div>
            <div class="bg-gray-100">
                <div class="max-w-12xl mx-auto">
                    <!-- Notifikasi -->
                    @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p class="font-bold">Sukses!</p>
                        </div>
                        <p>{{ session('message') }}</p>
                    </div>
                    @endif

                    <div class="py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-md">
                        <!-- Header dengan Tombol Tambah Anggota -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800">Daftar Team Kami</h2>
                            <a 
                                href="{{ route('team-kami.tambah') }}"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-plus mr-2"></i>Anggota
                            </a>
                        </div>

                        <!-- Filter -->
                        <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
                            <!-- Pencarian -->
                            <div class="flex flex-wrap gap-4 items-center">
                                <input 
                                    type="text" 
                                    class="w-full sm:w-60 md:w-64 lg:w-110 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Cari berdasarkan nama..." 
                                    wire:model.live.debounce.850ms="cariNama">
                            </div>
                        </div>

                        <!-- Tabel Daftar Team -->
                        <div class="overflow-x-auto py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($teams as $index => $anggota)
                                        <tr class="border-b">
                                            <!-- No. -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                            
                                            <!-- Foto -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="h-10 w-10 rounded-full overflow-hidden">
                                                    <img src="{{ asset('storage/' . $anggota->foto) }}" alt="{{ $anggota->nama }}" class="h-full w-full object-cover">
                                                </div>
                                            </td>
                                            
                                            <!-- Nama -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $anggota->nama }}</td>
                                            
                                            <!-- Jabatan -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $anggota->jabatan }}</td>
                                            
                                            <!-- Aksi -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a 
                                                        href="{{ route('team-kami.edit', $anggota->id) }}"
                                                        class="px-2 py-1 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button 
                                                       wire:click="$set('confirmingDelete', {{ $anggota->id }})"
                                                        class="px-2 py-1 bg-red-500 text-white text-xs rounded-md hover:bg-red-600">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data anggota team yang tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konfirmasi Hapus Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus anggota team ini?</p>
            <div class="flex justify-end space-x-4">
                <button 
                    wire:click="$set('confirmingDelete', false)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Batal
                </button>
                <button 
                    wire:click="hapusAnggota({{ $confirmingDelete }})"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script>
    // Konfirmasi sebelum menghapus
    document.addEventListener('livewire:initialized', () => {
        @this.on('confirm-delete', (id) => {
            if (confirm('Apakah Anda yakin ingin menghapus anggota team ini?')) {
                @this.call('hapusAnggota', id);
            }
        });
    });
</script>
@endpush

