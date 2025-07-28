<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('team-kami-list') }}">Daftar Team</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">{{ $isEdit ? 'Edit Anggota Team' : 'Tambah Anggota Team' }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="bg-gray-100">
                <div class="max-w-7xl mx-auto">
                    @if (session('message'))
                        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="max-w-12xl mx-auto p-6 bg-white shadow-lg rounded-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-700">
                            <i class="fas fa-users text-gray-500 mr-2"></i> 
                            {{ $isEdit ? 'Edit Anggota Team' : 'Tambah Anggota Team' }}
                        </h2>
                        
                        <form wire:submit.prevent="save">
                            <!-- Nama -->
                            <div class="mb-6">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    id="nama" 
                                    wire:model="nama" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Masukkan nama lengkap"
                                    required>
                                @error('nama')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div class="mb-6">
                                <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <input 
                                    type="text" 
                                    id="jabatan" 
                                    wire:model="jabatan" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Masukkan jabatan"
                                    required>
                                @error('jabatan')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div class="mb-6">
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                                
                                <!-- Preview Foto -->
                                @if ($fotoPreview)
                                    <div class="mt-4">
                                        <img src="{{ $fotoPreview }}" alt="Preview Foto" class="w-32 h-32 rounded-full object-cover border-2 border-gray-300">
                                    </div>
                                @endif
                                
                                <input 
                                    type="file" 
                                    id="foto" 
                                    wire:model="foto" 
                                    class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('foto')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Ukuran maksimal 2MB (format: jpg, png, jpeg)</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8">
                                <button 
                                    type="submit" 
                                    class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i>
                                    <span>{{ $isEdit ? 'Update Anggota Team' : 'Simpan Anggota Team' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>