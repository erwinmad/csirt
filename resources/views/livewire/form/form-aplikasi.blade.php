<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Informasi Dasar Aplikasi -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Informasi Dasar Aplikasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_aplikasi">
                        Nama Aplikasi <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="nama_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_aplikasi" type="text" placeholder="Nama Aplikasi">
                    @error('nama_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="url_aplikasi">
                        URL Aplikasi
                    </label>
                    <input wire:model="url_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="url_aplikasi" type="url" placeholder="https://example.com">
                    @error('url_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="skpd_id">
                        SKPD <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="skpd_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="skpd_id">
                        <option value="">Pilih SKPD</option>
                        @foreach($daftarSkpd as $skpd)
                            <option value="{{ $skpd->id }}">{{ $skpd->nama_skpd }}</option>
                        @endforeach
                    </select>
                    @error('skpd_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_id">
                        Jenis <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jenis_id">
                        <option value="">Pilih Jenis</option>
                        @foreach($jenis as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Klasifikasi Teknis -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Klasifikasi Teknis</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_aplikasi_id">
                        Jenis Aplikasi <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jenis_aplikasi_id">
                        <option value="">Pilih Jenis Aplikasi</option>
                        @foreach($jenisAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->jenis_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('jenis_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kategori_aplikasi_id">
                        Kategori Aplikasi <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="kategori_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kategori_aplikasi_id">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->kategori_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('kategori_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bahasa_aplikasi_id">
                        Bahasa Pemrograman <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="bahasa_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bahasa_aplikasi_id">
                        <option value="">Pilih Bahasa</option>
                        @foreach($bahasaAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->bahasa_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('bahasa_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="database_aplikasi_id">
                        Database <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="database_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="database_aplikasi_id">
                        <option value="">Pilih Database</option>
                        @foreach($databaseAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->database_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('database_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="framework_aplikasi_id">
                        Framework <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="framework_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="framework_aplikasi_id">
                        <option value="">Pilih Framework</option>
                        @foreach($frameworkAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->framework_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('framework_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="platform_aplikasi_id">
                        Platform <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="platform_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="platform_aplikasi_id">
                        <option value="">Pilih Platform</option>
                        @foreach($platformAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->platform_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('platform_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="pembuat_aplikasi_id">
                        Pembuat Aplikasi <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="pembuat_aplikasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pembuat_aplikasi_id">
                        <option value="">Pilih Pembuat</option>
                        @foreach($pembuatAplikasi as $item)
                            <option value="{{ $item->id }}">{{ $item->pembuat_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('pembuat_aplikasi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_pembuatan">
                        Tahun Pembuatan
                    </label>
                    <input wire:model="tahun_pembuatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tahun_pembuatan" type="text" placeholder="2023" maxlength="4">
                    @error('tahun_pembuatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Deskripsi Aplikasi -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Deskripsi Aplikasi</h2>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="uraian_aplikasi">
                    Uraian Aplikasi
                </label>
                <textarea wire:model="uraian_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="uraian_aplikasi" rows="3" placeholder="Deskripsi singkat tentang aplikasi"></textarea>
                @error('uraian_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fungsi_aplikasi">
                    Fungsi Aplikasi
                </label>
                <textarea wire:model="fungsi_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fungsi_aplikasi" rows="3" placeholder="Fungsi utama aplikasi"></textarea>
                @error('fungsi_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="output_aplikasi">
                    Output Aplikasi
                </label>
                <textarea wire:model="output_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="output_aplikasi" rows="3" placeholder="Output yang dihasilkan aplikasi"></textarea>
                @error('output_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pengembang_aplikasi">
                    Pengembang Aplikasi
                </label>
                <input wire:model="pengembang_aplikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pengembang_aplikasi" type="text" placeholder="Nama pengembang">
                @error('pengembang_aplikasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Status API -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Status API</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="link_api">
                        Link API
                    </label>
                    <input wire:model="link_api" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="link_api" type="url" placeholder="https://example.com/api">
                    @error('link_api') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_link_api">
                        Tahun Link API
                    </label>
                    <input wire:model="tahun_link_api" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tahun_link_api" type="text" placeholder="2023" maxlength="4">
                    @error('tahun_link_api') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="link_api_splp">
                        Link API SPLP
                    </label>
                    <input wire:model="link_api_splp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="link_api_splp" type="url" placeholder="https://example.com/api/splp">
                    @error('link_api_splp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_link_api_splp">
                        Tahun Link API SPLP
                    </label>
                    <input wire:model="tahun_link_api_splp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tahun_link_api_splp" type="text" placeholder="2023" maxlength="4">
                    @error('tahun_link_api_splp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Status Aplikasi -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-bold mb-6">Status Aplikasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Toggle Aktif -->
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <span class="text-gray-700 font-medium">Status Aktif</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Toggle Featured -->
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <span class="text-gray-700 font-medium">Featured</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input wire:model="is_featured" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>

                <!-- Toggle Terintegrasi -->
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <span class="text-gray-700 font-medium">Terintegrasi</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input wire:model="is_integrated" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan
            </button>
        </div>
    </form>
</div>