<?php

namespace App\Livewire\Form;

use Livewire\Component;
use App\Models\Teammodel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class TeamForm extends Component
{
    use WithFileUploads;

    public $teamId;
    public $nama;
    public $jabatan;
    public $foto;
    public $fotoPreview;
    public $isEdit = false;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'foto' => 'nullable|image|max:2048', // 2MB max
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->teamId = $id;
            $team = Teammodel::findOrFail($id);
            $this->nama = $team->nama;
            $this->jabatan = $team->jabatan;
            $this->fotoPreview = $team->foto ? Storage::url($team->foto) : null;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
        ];

        // Handle file upload
        if ($this->foto) {
            // Delete old photo if exists
            if ($this->isEdit && $this->fotoPreview) {
                Storage::delete(str_replace('storage/', 'public/', $this->fotoPreview));
            }
            
            $path = $this->foto->store('team','public');
            $data['foto'] = str_replace('public/', '', $path);
        }

        if ($this->isEdit) {
            $team = Teammodel::findOrFail($this->teamId);
            $team->update($data);
            session()->flash('message', 'Data team berhasil diperbarui!');
        } else {
            Teammodel::create($data);
            session()->flash('message', 'Data team berhasil ditambahkan!');
        }

        return redirect()->route('team-kami-list');
    }

    public function render()
    {
        return view('livewire.form.team-form')
            ->layout('components.layouts.app');
    }
}