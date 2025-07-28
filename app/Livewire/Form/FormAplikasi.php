<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class FormAplikasi extends Component
{
    use WithFileUploads;

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
    public $uraian_aplikasi;
    public $fungsi_aplikasi;
    public $output_aplikasi;
    public $pengembang_aplikasi;
    public $slug_aplikasi;
    public $is_active = false;
    public $is_featured = false;
    public $pembuat_aplikasi_id;
    public $tahun_pembuatan;

    protected $rules = [
        'nama_aplikasi' => 'required|string|max:255',
        'url_aplikasi' => 'nullable|url',
        'jenis_id' => 'required|exists:jenis,id',
        'skpd_id' => 'required|exists:daftar_skpd,id',
        'jenis_aplikasi_id' => 'required|exists:jenis_aplikasi,id',
        'kategori_aplikasi_id' => 'required|exists:kategori_aplikasi,id',
        'bahasa_aplikasi_id' => 'required|exists:bahasa_aplikasi,id',
        'database_aplikasi_id' => 'required|exists:database_aplikasi,id',
        'framework_aplikasi_id' => 'required|exists:framework_aplikasi,id',
        'platform_aplikasi_id' => 'required|exists:platform_aplikasi,id',
        'uraian_aplikasi' => 'nullable|string',
        'fungsi_aplikasi' => 'nullable|string',
        'output_aplikasi' => 'nullable|string',
        'pengembang_aplikasi' => 'nullable|string',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tahun_pembuatan' => 'nullable|string|max:4',
        'pembuat_aplikasi_id' => 'required|exists:pembuat_aplikasi,id',
    ];

    public function mount($aplikasiId = null)
    {
        if ($aplikasiId) {
            $this->aplikasiId = $aplikasiId;
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
                $this->uraian_aplikasi = $aplikasi->uraian_aplikasi;
                $this->fungsi_aplikasi = $aplikasi->fungsi_aplikasi;
                $this->output_aplikasi = $aplikasi->output_aplikasi;
                $this->pengembang_aplikasi = $aplikasi->pengembang_aplikasi;
                $this->is_active = $aplikasi->is_active;
                $this->is_featured = $aplikasi->is_featured;
                $this->tahun_pembuatan = $aplikasi->tahun_pembuatan;
                $this->pembuat_aplikasi_id = $aplikasi->pembuat_aplikasi_id;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
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
            'uraian_aplikasi' => $this->uraian_aplikasi,
            'fungsi_aplikasi' => $this->fungsi_aplikasi,
            'output_aplikasi' => $this->output_aplikasi,
            'pengembang_aplikasi' => $this->pengembang_aplikasi,
            'updated_at' => now(),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'tahun_pembuatan' => $this->tahun_pembuatan,
            'pembuat_aplikasi_id' => $this->pembuat_aplikasi_id,
        ];

        if ($this->aplikasiId) {
            DB::table('daftar_aplikasi')
                ->where('id', $this->aplikasiId)
                ->update($data);
            session()->flash('message', 'Aplikasi berhasil diperbarui.');
        } else {
            $data['created_at'] = now();
            DB::table('daftar_aplikasi')->insert($data);
            session()->flash('message', 'Aplikasi berhasil ditambahkan.');
        }

        $this->reset();
    }

    public function render()
    {
        $daftarSkpd                 = DB::table('daftar_skpd')->get();
        $jenisAplikasi              = DB::table('jenis_aplikasi')->get();
        $kategoriAplikasi           = DB::table('kategori_aplikasi')->get();
        $bahasaAplikasi             = DB::table('bahasa_aplikasi')->get();
        $jenis                      = DB::table('jenis')->get();
        $databaseAplikasi           = DB::table('database_aplikasi')->get();
        $frameworkAplikasi          = DB::table('framework_aplikasi')->get();
        $platformAplikasi           = DB::table('platform_aplikasi')->get();
        $pembuatAplikasi            = DB::table('pembuat_aplikasi')->get();
        $tahunPembuatan             = DB::table('daftar_aplikasi')
            ->select('tahun_pembuatan')
            ->distinct()
            ->orderBy('tahun_pembuatan', 'desc')
            ->get();


        return view('livewire.form.form-aplikasi', [
            'daftarSkpd'            => $daftarSkpd,
            'jenisAplikasi'         => $jenisAplikasi,
            'kategoriAplikasi'      => $kategoriAplikasi,
            'bahasaAplikasi'        => $bahasaAplikasi,
            'databaseAplikasi'      => $databaseAplikasi,
            'frameworkAplikasi'     => $frameworkAplikasi,
            'jenis'                 => $jenis,
            'platformAplikasi'      => $platformAplikasi,
            'pembuatAplikasi'       => $pembuatAplikasi,
           
        ]);
    }
}