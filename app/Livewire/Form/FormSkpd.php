<?php

namespace App\Livewire\Form;

use Livewire\Component;
use App\Models\SKPDModel;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormSkpd extends Component
{
    use WithFileUploads;

    public $skpdId; 
    public $kategori_skpd; 
    public $nama_skpd;
    public $alias_skpd;
    public $email_skpd;
    public $no_telp_skpd;
    public $website_skpd;
    public $logo_skpd; // Untuk menyimpan path logo lama
    public $new_logo_skpd; // Untuk upload logo baru
    public $alamat_skpd;

    protected $rules = [
        'nama_skpd' => 'required|string|max:255',
        'alias_skpd' => 'required|string|max:255',
        'email_skpd' => 'required|email|max:255',
        'no_telp_skpd' => 'required|string|max:15',
        'website_skpd' => 'required|url|max:255',
        'new_logo_skpd' => 'nullable|image|max:2048', // Validasi untuk file gambar baru
        'alamat_skpd' => 'required|string|max:255',
    ];

    // Metode mount akan dipanggil saat komponen diinisialisasi
    public function mount($skpdId = null)
    {
        if ($skpdId) {
            $this->skpdId = $skpdId;
            $this->loadSkpdData(); // Memuat data SKPD yang akan diedit
        }
    }

    // Metode untuk memuat data SKPD berdasarkan ID
    public function loadSkpdData()
    {
        $skpd = SKPDModel::find($this->skpdId);

        if ($skpd) {
            $this->nama_skpd = $skpd->nama_skpd;
            $this->alias_skpd = $skpd->alias_skpd;
            $this->email_skpd = $skpd->email_skpd;
            $this->no_telp_skpd = $skpd->no_telp_skpd;
            $this->website_skpd = $skpd->website_skpd;
            $this->logo_skpd = $skpd->logo_skpd; 
            $this->kategori_skpd = $skpd->skpd_id; 
            $this->alamat_skpd = $skpd->alamat_skpd;
        }
    }

    // Metode untuk menyimpan atau memperbarui data SKPD
    public function postSKPD()
    {
        $this->validate();

        $data = [
            'nama_skpd' => $this->nama_skpd,
            'alias_skpd' => $this->alias_skpd,
            'slug_skpd' => Str::slug($this->alias_skpd),
            'email_skpd' => $this->email_skpd,
            'skpd_id' => $this->kategori_skpd,
            'no_telp_skpd' => $this->no_telp_skpd,
            'website_skpd' => $this->website_skpd,
            'alamat_skpd' => $this->alamat_skpd,
        ];

        // Jika ada file logo baru diupload
        if ($this->new_logo_skpd) {
            $logoName = Str::slug($this->alias_skpd) . '-' . time() . '.' . $this->new_logo_skpd->getClientOriginalExtension();
            $logoPath = $this->new_logo_skpd->storeAs('logos', $logoName, 'public');
            $data['logo_skpd'] = $logoPath;

            // Hapus logo lama jika ada
            if ($this->logo_skpd && Storage::disk('public')->exists($this->logo_skpd)) {
                Storage::disk('public')->delete($this->logo_skpd);
            }
        }

        // Jika dalam mode edit, update data
        if ($this->skpdId) {
            SKPDModel::find($this->skpdId)->update($data);
            session()->flash('message', 'SKPD berhasil diperbarui.');
        } else {
            // Jika dalam mode tambah, buat data baru
            SKPDModel::create($data);
            session()->flash('message', 'SKPD berhasil ditambahkan.');
            $this->reset();
        }

        
    }

    public function render()
    {
        $data = [
            'skpd' => DB::table('kategori_skpd')->get(),
        ];

        return view('livewire.form.form-skpd', $data);
    }
}