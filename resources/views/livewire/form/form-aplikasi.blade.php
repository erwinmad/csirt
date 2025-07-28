<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Katalog Apps </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Daftar Aplikasi</flux:breadcrumbs.item>
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
                            <i class="fas fa-cogs text-gray-500 mr-2"></i> 
                            {{ $aplikasiId ? 'Edit Aplikasi' : 'Tambah Aplikasi' }}
                        </h2>
                        <form wire:submit.prevent="save">
                            <!-- Input Nama Aplikasi dan Slug -->
                            <div class="mb-6">
                                <x-input 
                                    id="nama_aplikasi" 
                                    label="Nama Aplikasi" 
                                    wireModel="nama_aplikasi" 
                                    placeholder="Masukkan Nama Aplikasi" />
                            </div>

                            <!-- Input URL Aplikasi -->
                            <div class="mb-6">
                                <x-input 
                                    id="url_aplikasi" 
                                    label="URL Aplikasi" 
                                    wireModel="url_aplikasi" 
                                    placeholder="Masukkan URL Aplikasi" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <x-select 
                                    id="skpd_id" 
                                    label="SKPD" 
                                    wireModel="skpd_id" 
                                    :options="$daftarSkpd->pluck('nama_skpd', 'id')" 
                                    defaultOption="Pilih SKPD" />

                                <x-select 
                                    id="jenis_id" 
                                    label="Jenis Aplikasi" 
                                    wireModel="jenis_aplikasi_id" 
                                    :options="$jenisAplikasi->pluck('jenis_aplikasi', 'id')" 
                                    defaultOption="Pilih Jenis Aplikasi" />
                                    
                                <x-select 
                                    id="jenis_id" 
                                    label="Jenis" 
                                    wireModel="jenis_id" 
                                    :options="$jenis->pluck('nama_jenis', 'id')" 
                                    defaultOption="Pilih Jenis" />
                                    
                                <x-input 
                                    id="tahun_pembuatan" 
                                    label="Tahun Pembuatan" 
                                    wireModel="tahun_pembuatan" 
                                    placeholder="Tahun Pembuatan Aplikasi" />

                                <x-select 
                                    id="kategori_aplikasi_id" 
                                    label="Kategori Aplikasi" 
                                    wireModel="kategori_aplikasi_id" 
                                    :options="$kategoriAplikasi->pluck('kategori_aplikasi', 'id')" 
                                    defaultOption="Pilih Kategori Aplikasi" />

                                <x-select 
                                    id="bahasa_aplikasi_id" 
                                    label="Bahasa Aplikasi" 
                                    wireModel="bahasa_aplikasi_id" 
                                    :options="$bahasaAplikasi->pluck('bahasa_aplikasi', 'id')" 
                                    defaultOption="Pilih Bahasa Aplikasi" />

                                <x-select 
                                    id="database_aplikasi_id" 
                                    label="Database Aplikasi" 
                                    wireModel="database_aplikasi_id" 
                                    :options="$databaseAplikasi->pluck('database_aplikasi', 'id')" 
                                    defaultOption="Pilih Database Aplikasi" />

                                <x-select 
                                    id="framework_aplikasi_id" 
                                    label="Framework Aplikasi" 
                                    wireModel="framework_aplikasi_id" 
                                    :options="$frameworkAplikasi->pluck('framework_aplikasi', 'id')" 
                                    defaultOption="Pilih Framework Aplikasi" />
                                <x-select 
                                    id="platform_aplikasi_id" 
                                    label="platform Aplikasi" 
                                    wireModel="platform_aplikasi_id" 
                                    :options="$platformAplikasi->pluck('platform_aplikasi', 'id')" 
                                    defaultOption="Pilih Platform Aplikasi" />

                                <x-select 
                                    id="pembuat_aplikasi_id" 
                                    label="pembuat Aplikasi" 
                                    wireModel="pembuat_aplikasi_id" 
                                    :options="$pembuatAplikasi->pluck('pembuat_aplikasi', 'id')" 
                                    defaultOption="Pilih Platform Aplikasi" />

                            </div>

                            <div class="mb-6">
                                <label for="uraian_aplikasi" class="block text-sm font-medium text-gray-700">Uraian Aplikasi</label>
                                <textarea 
                                    id="uraian_aplikasi" 
                                    wire:model="uraian_aplikasi" 
                                    rows="4" 
                                    class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm rounded-md" 
                                    placeholder="Masukkan Uraian Aplikasi"></textarea>
                                        @error('uraian_aplikasi')
                                        <x-input-error :message="$message" />
                                    @enderror
                            </div>

                            <div class="mb-6">
                                <label for="fungsi_aplikasi" class="block text-sm font-medium text-gray-700">Fungsi Aplikasi</label>
                                <textarea 
                                    id="fungsi_aplikasi" 
                                    wire:model="fungsi_aplikasi" 
                                    rows="4" 
                                    class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm rounded-md" 
                                    placeholder="Masukkan Fungsi Aplikasi"></textarea>
                                    @error('fungsi_aplikasi')
                                        <x-input-error :message="$message" />
                                    @enderror
                            </div>

                            <div class="mb-6">
                                <x-input 
                                    id="output_aplikasi" 
                                    label="Output Aplikasi" 
                                    wireModel="output_aplikasi" 
                                    placeholder="Masukkan Output Aplikasi" />
                            </div>

                            <div class="mb-6">
                                <x-input 
                                    id="pengembang_aplikasi" 
                                    label="Pengembang Aplikasi" 
                                    wireModel="pengembang_aplikasi" 
                                    placeholder="Masukkan Pengembang Aplikasi" />
                            </div>

                            <!-- Tombol Submit -->
                            <div class="mt-8">
                                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i>
                                    <span>{{ $aplikasiId ? 'Update Aplikasi' : 'Tambah Aplikasi' }}</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>