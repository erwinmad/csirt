<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Katalog Apps </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Daftar Perangkat Daerah</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class=" bg-gray-100">
                <div class="max-w-7xl mx-auto">
                    @if (session('message'))
                        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="max-w-12xl mx-auto p-6 bg-white shadow-lg rounded-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-700">
                            <i class="fas fa-building text-gray-500 mr-2"></i> 
                            {{ $skpdId ? 'Edit SKPD' : 'Tambah SKPD' }}
                        </h2>
                        <form wire:submit.prevent="postSKPD">
                            
                            <x-input 
                                id="nama_skpd" 
                                label="Nama SKPD" 
                                wireModel="nama_skpd" 
                                placeholder="Masukkan Nama SKPD" />
                            
                            <x-input 
                                id="alias_skpd" 
                                label="Alias SKPD" 
                                wireModel="alias_skpd" 
                                placeholder="Masukkan Alias SKPD" />
                            
                            <x-input 
                                id="email_skpd" 
                                label="Email SKPD" 
                                type="email" 
                                wireModel="email_skpd" 
                                placeholder="Masukkan Email SKPD" />

                            <x-input 
                                id="no_telp_skpd" 
                                label="No Telp SKPD" 
                                wireModel="no_telp_skpd" 
                                placeholder="Masukkan No Telp SKPD" />

                            <x-input 
                                id="website_skpd" 
                                label="Website SKPD" 
                                type="url" 
                                wireModel="website_skpd" 
                                placeholder="Masukkan Website SKPD" />

                            <x-select 
                                id="kategori_skpd" 
                                label="Kategori SKPD" 
                                wireModel="kategori_skpd" 
                                :options="$skpd->pluck('kategori_skpd', 'id')" 
                                defaultOption="Pilih Kategori SKPD" />

                            <div class="mb-6">
                                <label for="new_logo_skpd" class="block text-sm font-medium text-gray-700">Logo SKPD</label>
                                <input 
                                    type="file" 
                                    wire:model="new_logo_skpd" 
                                    id="new_logo_skpd" 
                                    class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('new_logo_skpd')
                                    <x-input-error :message="$message" />
                                @enderror
                                @if ($new_logo_skpd)
                                    <div class="mt-2">
                                        <img src="{{ $new_logo_skpd->temporaryUrl() }}" alt="Preview Logo" class="w-20 h-20 object-cover rounded">
                                    </div>
                                @elseif ($logo_skpd)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($logo_skpd) }}" alt="Current Logo" class="w-20 h-20 object-cover rounded">
                                    </div>
                                @endif
                            </div>

                            <x-input 
                                id="alamat_skpd" 
                                label="Alamat SKPD" 
                                wireModel="alamat_skpd" 
                                placeholder="Masukkan Alamat SKPD" />
  
                            <div class="mt-8">
                                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i>
                                    <span>{{ $skpdId ? 'Update SKPD' : 'Tambah SKPD' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>