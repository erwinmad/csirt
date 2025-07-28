<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $aplikasi;
    public $statusApi;
    public $skpd;
    public $error = null;
    public $activeTab = 'info'; // State untuk tab aktif

    public function mount($aplikasi_id)
    {
        try {
            // Query utama untuk data aplikasi
            $this->aplikasi = DB::selectOne("
                SELECT 
                    da.*, 
                    j.nama_jenis,
                    ja.jenis_aplikasi,
                    ka.kategori_aplikasi,
                    ba.bahasa_aplikasi,
                    dba.database_aplikasi,
                    fa.framework_aplikasi,
                    pa.platform_aplikasi,
                    pma.pembuat_aplikasi,
                    ds.nama_skpd
                FROM daftar_aplikasi da
                LEFT JOIN jenis j ON da.jenis_id = j.id
                LEFT JOIN jenis_aplikasi ja ON da.jenis_aplikasi_id = ja.id
                LEFT JOIN kategori_aplikasi ka ON da.kategori_aplikasi_id = ka.id
                LEFT JOIN bahasa_aplikasi ba ON da.bahasa_aplikasi_id = ba.id
                LEFT JOIN database_aplikasi dba ON da.database_aplikasi_id = dba.id
                LEFT JOIN framework_aplikasi fa ON da.framework_aplikasi_id = fa.id
                LEFT JOIN platform_aplikasi pa ON da.platform_aplikasi_id = pa.id
                LEFT JOIN pembuat_aplikasi pma ON da.pembuat_aplikasi_id = pma.id
                LEFT JOIN daftar_skpd ds ON da.skpd_id = ds.id
                WHERE da.id = ?
            ", [$aplikasi_id]);

            if (!$this->aplikasi) {
                throw new \Exception("Aplikasi tidak ditemukan");
            }

            // Query untuk status API
            $this->statusApi = DB::selectOne("
                SELECT * FROM status_api WHERE daftar_aplikasi_id = ?
            ", [$aplikasi_id]);

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}; ?>

<div class="p-4 space-y-6">
    <!-- Error Handling -->
    @if($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
        @return
    @endif

    <!-- Breadcrumbs -->
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#">CSIRT</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('skpd-list') }}">Daftar Aplikasi</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">{{ $aplikasi->nama_aplikasi }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="relative h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10 text-center p-6">
                <h1 class="text-3xl font-bold text-white">{{ $aplikasi->nama_aplikasi }}</h1>
                <div class="flex justify-center mt-4 space-x-3">
                    <span class="px-4 py-1 text-sm font-medium rounded-full 
                        {{ $aplikasi->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $aplikasi->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    @if($aplikasi->is_featured)
                    <span class="px-4 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                        Featured
                    </span>
                    @endif
                    @if($aplikasi->is_integrated)
                    <span class="px-4 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800">
                        Terintegrasi
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button wire:click="$set('activeTab', 'info')" 
                    class="{{ $activeTab === 'info' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Umum
                </button>
                <button wire:click="$set('activeTab', 'tech')" 
                    class="{{ $activeTab === 'tech' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    <i class="fas fa-code mr-2"></i>Detail Teknis
                </button>
                <button wire:click="$set('activeTab', 'api')" 
                    class="{{ $activeTab === 'api' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    <i class="fas fa-plug mr-2"></i>Status API
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Tab Informasi Umum -->
            @if($activeTab === 'info')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Deskripsi -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i> Deskripsi Aplikasi
                            </h2>
                            <div class="prose max-w-none text-gray-600">
                                {!! $aplikasi->uraian_aplikasi ? nl2br(e($aplikasi->uraian_aplikasi)) : '<p class="text-gray-400">Tidak ada deskripsi</p>' !!}
                            </div>
                        </div>

                        <!-- Fungsi dan Output -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-5 rounded-lg border border-blue-200">
                                <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-cogs text-blue-500 mr-2"></i> Fungsi Aplikasi
                                </h2>
                                <p class="text-gray-600">{{ $aplikasi->fungsi_aplikasi ?: 'Tidak tersedia' }}</p>
                            </div>
                            <div class="bg-green-50 p-5 rounded-lg border border-green-200">
                                <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-chart-line text-green-500 mr-2"></i> Output Aplikasi
                                </h2>
                                <p class="text-gray-600">{{ $aplikasi->output_aplikasi ?: 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Informasi Dasar -->
                        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-purple-500 mr-2"></i> Informasi Dasar
                            </h2>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500"></span>
                                    <span class="font-medium">{{ $aplikasi->nama_skpd }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jenis Aplikasi</span>
                                    <span class="font-medium">{{ $aplikasi->nama_jenis }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Kategori</span>
                                    <span class="font-medium">{{ $aplikasi->kategori_aplikasi ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tahun Pembuatan</span>
                                    <span class="font-medium">{{ $aplikasi->tahun_pembuatan ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pengembang</span>
                                    <span class="font-medium">{{ $aplikasi->pengembang_aplikasi ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pembuat</span>
                                    <span class="font-medium">{{ $aplikasi->pembuat_aplikasi }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- URL Aplikasi -->
                        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                            <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-link text-blue-500 mr-2"></i> URL Aplikasi
                            </h2>
                            @if($aplikasi->url_aplikasi)
                                <a href="{{ $aplikasi->url_aplikasi }}" target="_blank" 
                                   class="inline-flex items-center text-blue-600 hover:underline break-all">
                                    <i class="fas fa-external-link-alt mr-2"></i> {{ $aplikasi->url_aplikasi }}
                                </a>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-globe mr-1"></i> Live
                                    </span>
                                </div>
                            @else
                                <p class="text-gray-400 flex items-center">
                                    <i class="fas fa-unlink mr-2"></i> Tidak tersedia
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tab Detail Teknis -->
            @if($activeTab === 'tech')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Platform & Bahasa -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-laptop-code text-purple-500 mr-2"></i> Platform & Bahasa
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Platform</h3>
                                <p class="mt-1 text-lg font-medium">{{ $aplikasi->platform_aplikasi }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Bahasa Pemrograman</h3>
                                <p class="mt-1 text-lg font-medium">{{ $aplikasi->bahasa_aplikasi }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Framework</h3>
                                <p class="mt-1 text-lg font-medium">{{ $aplikasi->framework_aplikasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Database & Integrasi -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-database text-blue-500 mr-2"></i> Database & Integrasi
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Database</h3>
                                <p class="mt-1 text-lg font-medium">{{ $aplikasi->database_aplikasi }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Status Integrasi</h3>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $aplikasi->is_integrated ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $aplikasi->is_integrated ? 'Terintegrasi' : 'Tidak Terintegrasi' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Jenis Aplikasi</h3>
                                <p class="mt-1 text-lg font-medium">{{ $aplikasi->jenis_aplikasi ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Diagram Teknis (Placeholder) -->
                    <div class="md:col-span-2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-project-diagram text-red-500 mr-2"></i> Arsitektur Teknis
                        </h2>
                        <div class="bg-gray-50 rounded-lg p-8 text-center border-2 border-dashed border-gray-300">
                            <i class="fas fa-chart-pie text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500">Diagram arsitektur teknis aplikasi</p>
                            <button class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-upload mr-2"></i> Upload Diagram
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tab Status API -->
            @if($activeTab === 'api')
            <div class="space-y-6">
                @if($statusApi)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- API Utama -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-plug text-green-500 mr-2"></i> API Utama
                        </h2>
                        @if($statusApi->link_api)
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Endpoint API</h3>
                                <div class="mt-1 p-3 bg-gray-50 rounded-md font-mono text-sm break-all">
                                    {{ $statusApi->link_api }}
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tahun Pembuatan</h3>
                                <p class="mt-1 text-lg font-medium">{{ $statusApi->tahun_link_api ?: '-' }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ $statusApi->link_api }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-external-link-alt mr-2"></i> Test API
                                </a>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> Tidak ada API utama yang terdaftar
                        </p>
                        @endif
                    </div>

                    <!-- API SPLP -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-exchange-alt text-blue-500 mr-2"></i> API SPLP
                        </h2>
                        @if($statusApi->link_api_splp)
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Endpoint API</h3>
                                <div class="mt-1 p-3 bg-gray-50 rounded-md font-mono text-sm break-all">
                                    {{ $statusApi->link_api_splp }}
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tahun Pembuatan</h3>
                                <p class="mt-1 text-lg font-medium">{{ $statusApi->tahun_link_api_splp ?: '-' }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ $statusApi->link_api_splp }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-external-link-alt mr-2"></i> Test API
                                </a>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> Tidak ada API SPLP yang terdaftar
                        </p>
                        @endif
                    </div>
                </div>
                @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Tidak ada data API yang tersedia untuk aplikasi ini.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Terakhir diperbarui: {{ date('d M Y H:i', strtotime($aplikasi->updated_at)) }}
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('aplikasi.edit', $aplikasi->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>