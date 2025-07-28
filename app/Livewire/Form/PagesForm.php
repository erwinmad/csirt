<?php

namespace App\Livewire\Form;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PagesModel;
use App\Models\KatPagesModel;

class PagesForm extends Component
{
    use WithFileUploads;

    public $kategori_id;
    public $judul_halaman;
    public $deskripsi_halaman;
    public $ikon_halaman;
    public $gambar = [];
    public $status_halaman = false;
    public $pages_id;
    public $oldImages = [];
    public $pageTitle = 'Tambah Halaman Baru';

    protected function rules()
    {
        return [
            'kategori_id'       => 'required|exists:kategori_halaman,id',
            'judul_halaman'     => 'required|string|unique:halaman,judul_halaman,' . $this->pages_id,
            'deskripsi_halaman' => 'required|string',
            'ikon_halaman'      => 'nullable|string',
            'gambar.*'          => 'nullable|image|max:2048',
            'status_halaman'    => 'boolean',
        ];
    }

    public function mount($pages_id = null)
    {
        $this->pages_id = $pages_id;

        if ($pages_id) {
            $halaman = PagesModel::find($pages_id);

            if (!$halaman) {
                return $this->redirectWithError('Halaman tidak ditemukan');
            }

            $this->loadPageData($halaman);
        }
    }

    public function submitForm()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            $gambarPaths = $this->oldImages;

            // Handle new image uploads
            if ($this->gambar) {
                foreach ($this->gambar as $file) {
                    // Store to public disk
                    $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    $path = $file->storeAs('halaman', $filename, 'public');
                    $gambarPaths[] = $path;
                }
            }

            // Simpan data ke database
            $data = [
                'kategori_id' => $this->kategori_id,
                'judul_halaman' => $this->judul_halaman,
                'slug_halaman' => Str::slug($this->judul_halaman),
                'deskripsi_halaman' => $this->deskripsi_halaman,
                'gambar' => json_encode($gambarPaths),
                'status_halaman' => $this->status_halaman,
                'ikon_halaman' => $this->ikon_halaman,
            ];

            if ($this->pages_id) {
                PagesModel::findOrFail($this->pages_id)->update($data);
            } else {
                PagesModel::create(array_merge($data, ['views' => 0]));
            }

            DB::commit();
            
            // Clear temporary files and reset property
            $this->reset('gambar');
            
            session()->flash('message', 'Data berhasil disimpan');
            return redirect()->route('pages-list');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error: '.$e->getMessage());
            
            session()->flash('error', 'Gagal menyimpan data');
            return back();
        }
    }
    public function removeImage($imageToRemove)
    {
        $this->oldImages = array_filter($this->oldImages, fn($image) => $image !== $imageToRemove);
    }

    public function render()
    {
        return view('livewire.form.pages-form', [
            'kategoris' => KatPagesModel::all(),
            'isEdit'    => (bool) $this->pages_id,
        ]);
    }

    // --- Helper Methods ---

    protected function loadPageData(PagesModel $halaman)
    {
        $this->pageTitle         = 'Edit Halaman: ' . $halaman->judul_halaman;
        $this->kategori_id       = $halaman->kategori_id;
        $this->judul_halaman     = $halaman->judul_halaman;
        $this->deskripsi_halaman = $halaman->deskripsi_halaman;
        $this->ikon_halaman      = $halaman->ikon_halaman;
        $this->status_halaman    = (bool) $halaman->status_halaman;
        $this->oldImages         = is_array(json_decode($halaman->gambar, true)) 
                                   ? json_decode($halaman->gambar, true)
                                   : [];
    }

    protected function handleImageUploads()
    {
        $gambarPaths = $this->oldImages;

        foreach ($this->gambar as $file) {
            if (is_object($file)) {
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                          . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('halaman', $filename, 'public');
                $gambarPaths[] = $path;
            }
        }

        return $gambarPaths;
    }

    protected function preparePageData(array $gambarPaths)
    {
        return [
            'kategori_id'       => $this->kategori_id,
            'judul_halaman'     => $this->judul_halaman,
            'slug_halaman'      => Str::slug($this->judul_halaman),
            'deskripsi_halaman' => $this->deskripsi_halaman,
            'gambar'            => json_encode($gambarPaths),
            'status_halaman'    => $this->status_halaman,
            'ikon_halaman'      => $this->ikon_halaman,
        ];
    }

    protected function redirectWithSuccess($message)
    {
        session()->flash('ui.message', $message);
        session()->flash('ui.message_type', 'success');
        return redirect()->route('pages-list');
    }

    protected function redirectWithError($message)
    {
        session()->flash('ui.message', $message);
        session()->flash('ui.message_type', 'error');
        return redirect()->route('pages-list');
    }
}
