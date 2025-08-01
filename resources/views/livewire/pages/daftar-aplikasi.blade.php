<?php
 
use function Livewire\Volt\{with,state};
use App\Models\DaftarAplikasiModel;
use App\Exports\AplikasiExport;
use Maatwebsite\Excel\Facades\Excel;

state([
    'is_active',
    'is_featured',
    'is_integrated',
    'nama' => '',
    'bahasa' => '',
    'framework' => '',
    'jenis' => '',
    'kategori' => '',
    'platform' => '',
    'database' => '',
    'skpd' => '',
    'pembuat' => '',
    'tahun' => '',
    'jenises' => '',
]);

with(fn () => [
    'aplikasi' => DB::table('daftar_aplikasi')
        ->join('jenis_aplikasi', 'daftar_aplikasi.jenis_aplikasi_id', '=', 'jenis_aplikasi.id')
        ->join('kategori_aplikasi', 'daftar_aplikasi.kategori_aplikasi_id', '=', 'kategori_aplikasi.id')
        ->join('daftar_skpd', 'daftar_aplikasi.skpd_id', '=', 'daftar_skpd.id')
        ->join('jenis', 'daftar_aplikasi.jenis_id', '=', 'jenis.id')
        ->join('platform_aplikasi', 'daftar_aplikasi.platform_aplikasi_id', '=', 'platform_aplikasi.id')
        ->join('database_aplikasi', 'daftar_aplikasi.database_aplikasi_id', '=', 'database_aplikasi.id')
        ->join('framework_aplikasi', 'daftar_aplikasi.framework_aplikasi_id', '=', 'framework_aplikasi.id')  
        ->join('bahasa_aplikasi', 'daftar_aplikasi.bahasa_aplikasi_id', '=', 'bahasa_aplikasi.id')  
        ->join('pembuat_aplikasi', 'daftar_aplikasi.pembuat_aplikasi_id', '=', 'pembuat_aplikasi.id')  
        ->select(
            'daftar_aplikasi.id',
            'daftar_aplikasi.is_featured',
            'daftar_aplikasi.is_active',
            'daftar_aplikasi.is_integrated',
            'daftar_aplikasi.nama_aplikasi',
            'jenis.nama_jenis',
            'platform_aplikasi.platform_aplikasi',
            'database_aplikasi.database_aplikasi',
            'framework_aplikasi.framework_aplikasi',
            'bahasa_aplikasi.bahasa_aplikasi',
            'pembuat_aplikasi.pembuat_aplikasi',
            'kategori_aplikasi.kategori_aplikasi as kategori',
            'jenis_aplikasi.jenis_aplikasi as jenis',
            'daftar_aplikasi.url_aplikasi as url',
            'daftar_skpd.alias_skpd as dinas'
        )
        ->when($this->nama, fn ($query, $nama) => $query->where('daftar_aplikasi.nama_aplikasi', 'like', "%{$nama}%"))
        ->when($this->bahasa, fn ($query, $bahasa) => $query->where('bahasa_aplikasi.id', $bahasa))
        ->when($this->pembuat, fn ($query, $pembuat) => $query->where('pembuat_aplikasi.id', $pembuat))
        ->when($this->framework, fn ($query, $framework) => $query->where('framework_aplikasi.id', $framework))
        ->when($this->jenis, fn ($query, $jenis) => $query->where('jenis_aplikasi.id', $jenis))
        ->when($this->kategori, fn ($query, $kategori) => $query->where('kategori_aplikasi.id', $kategori))
        ->when($this->platform, fn ($query, $platform) => $query->where('platform_aplikasi.id', $platform))
        ->when($this->jenises, fn ($query, $jenises) => $query->where('jenis.id', $jenises))
        ->when($this->database, fn ($query, $database) => $query->where('database_aplikasi.id', $database))
        ->when($this->skpd, fn ($query, $skpd) => $query->where('daftar_skpd.id', $skpd))
        ->when($this->tahun, fn ($query, $tahun) => $query->where('daftar_aplikasi.tahun_pembuatan', $tahun))
        ->orderBy('daftar_aplikasi.id', 'desc')
        ->paginate(10),
    'jenisAplikasi' => DB::table('jenis_aplikasi')->get(),
    'kategoriAplikasi' => DB::table('kategori_aplikasi')->get(),
    'platformAplikasi' => DB::table('platform_aplikasi')->get(),
    'databaseAplikasi' => DB::table('database_aplikasi')->get(),
    'frameworkAplikasi' => DB::table('framework_aplikasi')->get(),
    'jenisOptions' => DB::table('jenis')->get(),    
    'bahasaAplikasi' => DB::table('bahasa_aplikasi')->get(),
    'daftarSkpd' => DB::table('daftar_skpd')->get(),
    'pembuatSkpd' => DB::table('pembuat_aplikasi')->get(),
    'tahunPembuatan' => DB::table('daftar_aplikasi')->select('tahun_pembuatan')->distinct()->get(),
]);

$toggleStatus = function ($id) {
    $toggle = DaftarAplikasiModel::find($id);
    if ($toggle) {
        $toggle->is_active = !$toggle->is_active;
        $toggle->save();
    }
};

$toggleFeatured = function ($id) {
    $toggle = DaftarAplikasiModel::find($id);
    if ($toggle) {
        $toggle->is_featured = !$toggle->is_featured;
        $toggle->save();
    }
};

$toggleIntegrated = function ($id) {
    $toggle = DaftarAplikasiModel::find($id);
    if ($toggle) {
        $toggle->is_integrated = !$toggle->is_integrated;
        $toggle->save();
    }
};

$exportExcel = function () {
    $filters = [
        'nama' => $this->nama,
        'jenises' => $this->jenises,
        'bahasa' => $this->bahasa,
        'framework' => $this->framework,
        'jenis' => $this->jenis,
        'kategori' => $this->kategori,
        'platform' => $this->platform,
        'database' => $this->database,
        'skpd' => $this->skpd,
        'pembuat' => $this->pembuat,
        'tahun_pembuatan' => $this->tahun,
    ];
    
    $fileName = now()->format('Ymd_His') . '_DaftarAplikasi.xlsx';
    return Excel::download(new AplikasiExport($filters), $fileName);
};

?>

<div>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">Katalog Apps </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('skpd-list') }}">Daftar Aplikasi</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">

                <!-- Header with Add User Button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-gray-800">Daftar Aplikasi</h2>
                    <div class="flex gap-2">
                        <!-- Tombol Export Excel -->
                        <button 
                            wire:click="exportExcel"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                            <i class="fas fa-file-excel mr-2"></i> Excel
                        </button>
                        <!-- Tombol Export PDF -->
                        <button 
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                            <i class="fas fa-file-pdf mr-2"></i> PDF
                        </button>
                        <!-- Tombol Tambah Pengguna -->
                        <a 
                            href="{{ route('aplikasi.create') }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                            <i class="fas fa-plus-circle mr-2"></i> Aplikasi
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                   
                    <!-- Filter Bahasa -->
                    <select 
                        wire:model.live="jenises"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Jenis</option>
                        @foreach($jenisOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->nama_jenis }}</option>
                        @endforeach
                    </select>

                    <select 
                        wire:model.live="bahasa"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Bahasa</option>
                        @foreach($bahasaAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->bahasa_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Framework -->
                    <select 
                        wire:model.live="framework"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Framework</option>
                        @foreach($frameworkAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->framework_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Jenis -->
                    <select 
                        wire:model.live="jenis"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Jenis Aplikasi</option>
                        @foreach($jenisAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->jenis_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Kategori -->
                    <select 
                        wire:model.live="kategori"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->kategori_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Platform -->
                    <select 
                        wire:model.live="platform"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Platform</option>
                        @foreach($platformAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->platform_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Database -->
                    <select 
                        wire:model.live="database"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Database</option>
                        @foreach($databaseAplikasi as $option)
                            <option value="{{ $option->id }}">{{ $option->database_aplikasi }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Filter SKPD -->
                    <select 
                        wire:model.live="skpd"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih SKPD</option>
                        @foreach($daftarSkpd as $option)
                            <option value="{{ $option->id }}">{{ $option->alias_skpd }}</option>
                        @endforeach
                    </select>

                    <!-- Pembuat Aplikasi -->
                    <select 
                        wire:model.live="pembuat"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Asal Aplikasi</option>
                        @foreach($pembuatSkpd as $option)
                            <option value="{{ $option->id }}">{{ $option->pembuat_aplikasi }}</option>
                        @endforeach
                    </select>

                    <select 
                        wire:model.live="tahun"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Tahun Pembuatan</option>
                        @foreach($tahunPembuatan as $tahun)
                            <option value="{{ $tahun->tahun_pembuatan }}">{{ $tahun->tahun_pembuatan }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Nama -->
                    <input 
                        type="text" 
                        wire:model.live="nama"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari berdasarkan nama aplikasi...">

                </div>
        
                <div class="overflow-x-auto py-6 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Aplikasi</th>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th> --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dinas Pengampu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($aplikasi as $row)
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ($aplikasi->currentPage() - 1) * $aplikasi->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><a href="{{ route('detail-aplikasi', $row->id) }}">{{ $row->nama_aplikasi }}</a></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->nama_jenis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-link text-blue-500 text-xs"></i>
                                            <a href="{{ $row->url }}" target="_blank" class="text-xs text-blue-500 hover:underline">{{ Str::limit($row->url, 20) }}</a> 
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-building text-green-500 text-xs"></i>
                                            <span class="text-xs">{{ $row->dinas }}</span> 
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-1">
                                        <button 
                                            wire:click="toggleStatus({{ $row->id }})"
                                            class="px-2 py-1 text-xs rounded-md {{ $row->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                            {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                        <button 
                                            wire:click="toggleFeatured({{ $row->id }})"
                                            class="px-2 py-1 text-xs rounded-md {{ $row->is_featured ? 'bg-blue-500 text-white' : 'bg-gray-500 text-white' }}">
                                            {{ $row->is_featured ? 'Featured' : 'Biasa' }}
                                        </button>
                                        <button 
                                            wire:click="toggleIntegrated({{ $row->id }})"
                                            class="px-2 py-1 text-xs rounded-md {{ $row->is_integrated ? 'bg-purple-500 text-white' : 'bg-yellow-500 text-white' }}">
                                            {{ $row->is_integrated ? 'Terintegrasi' : 'Standalone' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a class="text-blue-600 hover:text-blue-900 mr-2 text-sm" 
                                            href="{{ route('aplikasi.edit', $row->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="text-cyan-600 hover:text-cyan-900 mr-2 text-sm" 
                                            href="{{ route('detail-aplikasi', $row->id) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada aplikasi yang diinput.</td>
                                </tr>   
                            @endforelse
                        </tbody>
                    </table>
                </div>
        
                <div class="mt-4">
                    {{ $aplikasi->links() }}
                </div>

            </div>
        </div>
    </div>
</div>