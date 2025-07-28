<?php

use Livewire\Volt\Component;
use App\Models\ProfilModel;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $profil;
    public $nama;
    public $email;
    public $telp;
    public $alamat;
    public $website;
    public $instagram;
    public $foto;
    public $fotoPreview;

    public function mount()
    {
        // Ambil data profil dengan ID 1
        $this->profil = ProfilModel::find(1);
        
        if ($this->profil) {
            $this->nama = $this->profil->nama;
            $this->email = $this->profil->email;
            $this->telp = $this->profil->telp;
            $this->alamat = $this->profil->alamat;
            $this->website = $this->profil->website;
            $this->instagram = $this->profil->instagram;
            $this->fotoPreview = $this->profil->foto_path ? asset('storage/'.$this->profil->foto_path) : null;
        }
    }

    public function updatedFoto()
    {
        $this->validate([
            'foto' => ['image', 'max:2048', 'mimes:jpg,png,jpeg'],
        ], [
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran file maksimal 2MB',
            'foto.mimes' => 'Format file harus JPG, PNG, atau JPEG',
        ]);
        
        $this->fotoPreview = $this->foto->temporaryUrl();
    }

    public function save()
    {
        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telp' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+]+$/'],
            'alamat' => ['required', 'string', 'max:500'],
            'website' => ['required', 'url', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._]+$/'],
            'foto' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
        ], [
            'nama.required' => 'Nama perusahaan wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'telp.required' => 'Nomor telepon wajib diisi',
            'telp.regex' => 'Format nomor telepon tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'website.required' => 'Website wajib diisi',
            'website.url' => 'Format URL website tidak valid',
            'instagram.regex' => 'Format username Instagram tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran file maksimal 2MB',
            'foto.mimes' => 'Format file harus JPG, PNG, atau JPEG',
        ]);

        try {
            if ($this->foto) {
                $validated['foto_path'] = $this->foto->store('profil', 'public');
            }

            if ($this->profil) {
                $this->profil->update($validated);
                session()->flash('success', 'Profil berhasil diperbarui!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan profil: '.$e->getMessage());
        }
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="/">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Pengaturan</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Edit Profil</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        
        <div class="relative h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="bg-gray-100">
                <div class="max-w-7xl mx-auto">
                    <!-- Notifikasi -->
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="max-w-12xl mx-auto p-6 bg-white shadow-lg rounded-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-700">
                            <i class="fas fa-building text-gray-500 mr-2"></i> 
                            Edit Profil Perusahaan
                        </h2>
                        
                        @if($profil)
                            <form wire:submit.prevent="save">
                                <!-- Nama -->
                                <div class="mb-6">
                                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Perusahaan <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        id="nama" 
                                        wire:model="nama" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Masukkan nama perusahaan">
                                    @error('nama')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-6">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        wire:model="email" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="contoh@perusahaan.com">
                                    @error('email')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Telepon -->
                                <div class="mb-6">
                                    <label for="telp" class="block text-sm font-medium text-gray-700">Telepon <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        id="telp" 
                                        wire:model="telp" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Contoh: 08123456789">
                                    @error('telp')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Gunakan format angka saja (contoh: 08123456789)</p>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-6">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat <span class="text-red-500">*</span></label>
                                    <textarea 
                                        id="alamat" 
                                        wire:model="alamat" 
                                        rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Masukkan alamat lengkap perusahaan"></textarea>
                                    @error('alamat')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Website -->
                                <div class="mb-6">
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website <span class="text-red-500">*</span></label>
                                    <input 
                                        type="url" 
                                        id="website" 
                                        wire:model="website" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Contoh: https://adsfasdfasd.com">
                                    @error('website')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div class="mb-6">
                                    <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            @
                                        </span>
                                        <input 
                                            type="text" 
                                            id="instagram" 
                                            wire:model="instagram" 
                                            class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="username">
                                    </div>
                                    @error('instagram')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Masukkan username tanpa @ (contoh: supreme_zhuxin)</p>
                                </div>

                                <!-- Foto -->
                                <div class="mb-6">
                                    <label for="foto" class="block text-sm font-medium text-gray-700">Logo Perusahaan</label>
                                    
                                    <!-- Preview Foto -->
                                    @if ($fotoPreview)
                                        <div class="mt-4 flex items-center">
                                            <img src="{{ $fotoPreview }}" alt="Preview Logo" class="w-32 h-32 rounded-full object-cover border-2 border-gray-300">
                                            <button 
                                                type="button" 
                                                wire:click="$set('foto', null)" 
                                                wire:confirm="Apakah Anda yakin ingin menghapus logo ini?"
                                                class="ml-4 text-red-500 hover:text-red-700 text-sm flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Hapus Logo
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <input 
                                        type="file" 
                                        id="foto" 
                                        wire:model="foto" 
                                        class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @error('foto')
                                        <div class="mt-1 text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Ukuran maksimal 2MB (format: JPG, PNG, JPEG)</p>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-8">
                                    <button 
                                        type="submit" 
                                        class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 text-sm">
                                        <i class="fas fa-save"></i>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>Data profil tidak ditemukan. Silahkan buat data profil terlebih dahulu.</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>