<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class FormAplikasi extends Component
{
    use WithFileUploads;

    // Field untuk tabel daftar_aplikasi
    public $aplikasiId;
    public $nama_aplikasi;
    public $url_aplikasi;
    public $skpd_id;
    public $jenis_id;
    public $jenis_aplikasi_id;
    public $kategori_aplikasi_id;
    public $bahasa_aplikasi_id;
    public $database_aplikasi_id;
    public $framework_aplikasi_id;
    public $platform_aplikasi_id;
    public $pembuat_aplikasi_id;
    public $uraian_aplikasi;
    public $tahun_pembuatan;
    public $fungsi_aplikasi;
    public $output_aplikasi;
    public $pengembang_aplikasi;
    public $is_active = false;
    public $is_featured = false;
    public $is_integrated = false;

    // Field untuk tabel status_api
    public $link_api;
    public $tahun_link_api;
    public $link_api_splp;
    public $tahun_link_api_splp;

    protected $rules = [
        // Rules untuk daftar_aplikasi
        'nama_aplikasi' => 'required|string|max:255',
        'url_aplikasi' => 'nullable|url',
        'skpd_id' => 'required|exists:daftar_skpd,id',
        'jenis_id' => 'required|exists:jenis,id',
        'jenis_aplikasi_id' => 'required|exists:jenis_aplikasi,id',
        'kategori_aplikasi_id' => 'required|exists:kategori_aplikasi,id',
        'bahasa_aplikasi_id' => 'required|exists:bahasa_aplikasi,id',
        'database_aplikasi_id' => 'required|exists:database_aplikasi,id',
        'framework_aplikasi_id' => 'required|exists:framework_aplikasi,id',
        'platform_aplikasi_id' => 'required|exists:platform_aplikasi,id',
        'pembuat_aplikasi_id' => 'required|exists:pembuat_aplikasi,id',
        'uraian_aplikasi' => 'nullable|string',
        'tahun_pembuatan' => 'nullable|string|max:4',
        'fungsi_aplikasi' => 'nullable|string',
        'output_aplikasi' => 'nullable|string',
        'pengembang_aplikasi' => 'nullable|string',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_integrated' => 'boolean',
        
        // Rules untuk status_api
        'link_api' => 'nullable|url',
        'tahun_link_api' => 'nullable|string|max:4',
        'link_api_splp' => 'nullable|url',
        'tahun_link_api_splp' => 'nullable|string|max:4',
    ];

    public function mount($aplikasiId = null)
    {
        if ($aplikasiId) {
            $this->aplikasiId = $aplikasiId;
            
            // Load data aplikasi
            $aplikasi = DB::table('daftar_aplikasi')->where('id', $aplikasiId)->first();
            
            if ($aplikasi) {
                $this->nama_aplikasi = $aplikasi->nama_aplikasi;
                $this->url_aplikasi = $aplikasi->url_aplikasi;
                $this->skpd_id = $aplikasi->skpd_id;
                $this->jenis_id = $aplikasi->jenis_id;
                $this->jenis_aplikasi_id = $aplikasi->jenis_aplikasi_id;
                $this->kategori_aplikasi_id = $aplikasi->kategori_aplikasi_id;
                $this->bahasa_aplikasi_id = $aplikasi->bahasa_aplikasi_id;
                $this->database_aplikasi_id = $aplikasi->database_aplikasi_id;
                $this->framework_aplikasi_id = $aplikasi->framework_aplikasi_id;
                $this->platform_aplikasi_id = $aplikasi->platform_aplikasi_id;
                $this->pembuat_aplikasi_id = $aplikasi->pembuat_aplikasi_id;
                $this->uraian_aplikasi = $aplikasi->uraian_aplikasi;
                $this->tahun_pembuatan = $aplikasi->tahun_pembuatan;
                $this->fungsi_aplikasi = $aplikasi->fungsi_aplikasi;
                $this->output_aplikasi = $aplikasi->output_aplikasi;
                $this->pengembang_aplikasi = $aplikasi->pengembang_aplikasi;
                $this->is_active = (bool)$aplikasi->is_active;
                $this->is_featured = (bool)$aplikasi->is_featured;
                $this->is_integrated = (bool)$aplikasi->is_integrated;
            }
            
            // Load data status API
            $statusApi = DB::table('status_api')->where('daftar_aplikasi_id', $aplikasiId)->first();
            if ($statusApi) {
                $this->link_api = $statusApi->link_api;
                $this->tahun_link_api = $statusApi->tahun_link_api;
                $this->link_api_splp = $statusApi->link_api_splp;
                $this->tahun_link_api_splp = $statusApi->tahun_link_api_splp;
            }
        }
    }

    public function save()
    {
        $this->validate();

        // Data untuk tabel daftar_aplikasi
        $aplikasiData = [
            'nama_aplikasi' => $this->nama_aplikasi,
            'url_aplikasi' => $this->url_aplikasi,
            'slug_aplikasi' => Str::slug($this->nama_aplikasi),
            'skpd_id' => $this->skpd_id,
            'jenis_id' => $this->jenis_id,
            'jenis_aplikasi_id' => $this->jenis_aplikasi_id,
            'kategori_aplikasi_id' => $this->kategori_aplikasi_id,
            'bahasa_aplikasi_id' => $this->bahasa_aplikasi_id,
            'database_aplikasi_id' => $this->database_aplikasi_id,
            'framework_aplikasi_id' => $this->framework_aplikasi_id,
            'platform_aplikasi_id' => $this->platform_aplikasi_id,
            'pembuat_aplikasi_id' => $this->pembuat_aplikasi_id,
            'uraian_aplikasi' => $this->uraian_aplikasi,
            'tahun_pembuatan' => $this->tahun_pembuatan,
            'fungsi_aplikasi' => $this->fungsi_aplikasi,
            'output_aplikasi' => $this->output_aplikasi,
            'pengembang_aplikasi' => $this->pengembang_aplikasi,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'is_integrated' => $this->is_integrated,
            'updated_at' => now(),
        ];

        // Data untuk tabel status_api
        $statusApiData = [
            'link_api' => $this->link_api,
            'tahun_link_api' => $this->tahun_link_api,
            'link_api_splp' => $this->link_api_splp,
            'tahun_link_api_splp' => $this->tahun_link_api_splp,
            'updated_at' => now(),
        ];

        if ($this->aplikasiId) {
            // Update aplikasi
            DB::table('daftar_aplikasi')
                ->where('id', $this->aplikasiId)
                ->update($aplikasiData);

            // Update atau create status_api
            if (DB::table('status_api')->where('daftar_aplikasi_id', $this->aplikasiId)->exists()) {
                DB::table('status_api')
                    ->where('daftar_aplikasi_id', $this->aplikasiId)
                    ->update($statusApiData);
            } else {
                $statusApiData['daftar_aplikasi_id'] = $this->aplikasiId;
                $statusApiData['created_at'] = now();
                DB::table('status_api')->insert($statusApiData);
            }

            session()->flash('message', 'Aplikasi berhasil diperbarui.');
        } else {
            // Insert aplikasi baru
            $aplikasiData['created_at'] = now();
            DB::table('daftar_aplikasi')->insert($aplikasiData);

            // Get ID aplikasi yang baru dibuat
            $aplikasiId = DB::getPdo()->lastInsertId();

            // Insert status_api
            $statusApiData['daftar_aplikasi_id'] = $aplikasiId;
            $statusApiData['created_at'] = now();
            DB::table('status_api')->insert($statusApiData);

            session()->flash('message', 'Aplikasi berhasil ditambahkan.');
        }

        $this->reset();
    }

    public function render()
    {
        return view('livewire.form.form-aplikasi', [
            'daftarSkpd' => DB::table('daftar_skpd')->get(),
            'jenisAplikasi' => DB::table('jenis_aplikasi')->get(),
            'kategoriAplikasi' => DB::table('kategori_aplikasi')->get(),
            'bahasaAplikasi' => DB::table('bahasa_aplikasi')->get(),
            'jenis' => DB::table('jenis')->get(),
            'databaseAplikasi' => DB::table('database_aplikasi')->get(),
            'frameworkAplikasi' => DB::table('framework_aplikasi')->get(),
            'platformAplikasi' => DB::table('platform_aplikasi')->get(),
            'pembuatAplikasi' => DB::table('pembuat_aplikasi')->get(),
            'tahunPembuatan' => DB::table('daftar_aplikasi')
                ->select('tahun_pembuatan')
                ->distinct()
                ->orderBy('tahun_pembuatan', 'desc')
                ->get(),
        ]);
    }
}