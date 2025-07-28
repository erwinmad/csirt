<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('berita-list') }}">Daftar Berita</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">{{ $beritaId ? 'Edit Berita' : 'Tambah Berita' }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="bg-gray-100">
                <div class="max-w-7xl mx-auto">
                    @if (session('message'))
                        <div class="{{ session('messageType') === 'error' ? 'bg-red-500' : 'bg-green-500' }} text-white p-4 rounded-lg mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="max-w-12xl mx-auto p-6 bg-white shadow-lg rounded-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-700">
                            <i class="fas fa-newspaper text-gray-500 mr-2"></i> 
                            {{ $beritaId ? 'Edit Berita - ' .$judul_berita : 'Tambah Berita Baru' }}
                        </h2>
                        <form wire:submit.prevent="save">
                            <x-select 
                                id="kategori_id" 
                                label="Kategori Berita" 
                                wireModel="kategori_id" 
                                :options="$kategoris->pluck('nama_kategori', 'id')" 
                                defaultOption="Pilih Kategori Berita" 
                                required />

                            <x-input 
                                id="judul_berita" 
                                label="Judul Berita" 
                                wireModel="judul_berita" 
                                placeholder="Masukkan Judul Berita"
                                required />

                            <x-input 
                                id="tgl_berita" 
                                label="Tanggal Berita" 
                                type="date"
                                wireModel="tgl_berita" 
                                required />

                            <div class="mb-6">
                                <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                                <textarea 
                                    wire:model="isi_berita" 
                                    id="isi_berita" 
                                    rows="8"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Masukkan Isi Berita"
                                    required></textarea>
                                @error('isi_berita')
                                    <x-input-error :message="$message" />
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Berita</label>
                                <input 
                                    type="file" 
                                    wire:model="gambar" 
                                    id="gambar" 
                                    multiple
                                    class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('gambar.*')
                                    <x-input-error :message="$message" />
                                @enderror
                                
                                <!-- Preview new images -->
                                @if ($gambar)
                                    <div class="mt-4 grid grid-cols-3 gap-4">
                                        @foreach ($gambar as $file)
                                            <div class="relative">
                                                <img src="{{ $file->temporaryUrl() }}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Show existing images -->
                                @if (count($oldImages) > 0)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini:</h4>
                                        <div class="grid grid-cols-3 gap-4">
                                            @foreach ($oldImages as $image)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Current Image" class="w-full h-32 object-cover rounded-lg">
                                                    <button 
                                                        type="button" 
                                                        wire:click="removeImage('{{ $image }}')" 
                                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-times text-xs"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-6">
                                <label class="inline-flex items-center">
                                    <input 
                                        type="checkbox" 
                                        wire:model="status_berita" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Publikasikan Berita</span>
                                </label>
                            </div>
  
                            <div class="mt-8">
                                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i>
                                    <span>{{ $beritaId ? 'Update Berita' : 'Simpan Berita' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>