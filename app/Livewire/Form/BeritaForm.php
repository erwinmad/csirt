<?php

namespace App\Livewire\Form;

use Livewire\Component;
use App\Models\BeritaModel;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\KatBeritaModel;

class BeritaForm extends Component
{
    use WithFileUploads;

    public $beritaId;
    public $kategori_id;
    public $judul_berita;
    public $slug_berita;
    public $tgl_berita;
    public $isi_berita;
    public $gambar = [];
    public $oldImages = [];
    public $status_berita = false;
   
    protected $rules = [
        'kategori_id' => 'required|exists:kategori_berita,id',
        'judul_berita' => 'required|string|max:255|unique:berita,judul_berita',
        'tgl_berita' => 'required|date',
        'isi_berita' => 'required|string',
        'gambar.*' => 'nullable|image|max:2048',
        'status_berita' => 'boolean',
       
    ];

    public function mount($beritaId = null)
    {
        if ($beritaId) {
            $berita = BeritaModel::findOrFail($beritaId);
            
            $this->beritaId = $berita->id;
            $this->kategori_id = $berita->kategori_id;
            $this->judul_berita = $berita->judul_berita;
            $this->slug_berita = $berita->slug_berita;
            $this->isi_berita = $berita->isi_berita;
            $this->status_berita = $berita->status_berita;
            $this->tgl_berita = $berita->tgl_berita->format('Y-m-d');
            $this->oldImages = json_decode($berita->gambar, true) ?? [];
        
            $this->rules['judul_berita'] = 'required|string|max:255|unique:berita,judul_berita,'.$this->beritaId;
        }
    }



    public function save()
    {
        $validated = $this->validate();

        $uploadedImages = array_map(function ($image) {
            $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $newFilename = $filename . '_' . microtime(true) . '.' . $extension;
        
            return $image->storeAs('berita', $newFilename, 'public'); // Simpan ke public disk
        }, $this->gambar);
        
        $allImages = [...$this->oldImages, ...$uploadedImages];

        $beritaData = [
            ...$validated,
            'slug_berita' => Str::slug($this->judul_berita),
            'gambar' => json_encode($allImages),
        ];

        $berita = $this->beritaId 
            ? BeritaModel::find($this->beritaId)->update($beritaData)
            : BeritaModel::create($beritaData);

        // Hapus sync dengan dewan:
        // $berita->dewans()->sync($this->selectedDewan);

        session()->flash('message', $this->beritaId ? 'Berita berhasil diperbarui' : 'Berita berhasil dibuat');
        session()->flash('messageType', 'success');

        return redirect()->route('berita-list');
    }

    public function render()
    {
        return view('livewire.form.berita-form', [
            'kategoris' => KatBeritaModel::select('id', 'nama_kategori')->get(),
        ]);
    }
}