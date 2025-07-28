<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\JenisAduan;
use App\Models\DaftarAplikasiModel;
use App\Models\AduanSiber;
use App\Models\AduanSiberPelapor;
use App\Models\ProgresAduanSiber;
use Illuminate\Support\Str;

new 
#[Layout('components.layouts.guest')]
class extends Component {
    use WithFileUploads;

    public $aplikasi_id;
    public $jenis_aduan_id;
    public $judul_aduan;
    public $deskripsi_aduan;
    public $foto_aduan;
    public $nama_pengadu;
    public $email_pengadu;
    public $no_telp_pengadu;

    public $daftarAplikasi;
    public $jenisAduan;

    public function mount()
    {
        $this->daftarAplikasi = DaftarAplikasiModel::all();
        $this->jenisAduan = JenisAduan::all();
    }

    public function submitAduan()
    {
        $validated = $this->validate([
            'aplikasi_id' => 'required|exists:daftar_aplikasi,id',
            'jenis_aduan_id' => 'required|exists:jenis_aduan,id',
            'judul_aduan' => 'required|string|max:255',
            'deskripsi_aduan' => 'required|string',
            'foto_aduan' => 'nullable|image|max:2048',
            'nama_pengadu' => 'required|string|max:255',
            'email_pengadu' => 'nullable|email',
            'no_telp_pengadu' => 'nullable|string|max:20',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Handle file upload
                $fotoPath = null;
                if ($this->foto_aduan) {
                    $fotoPath = $this->foto_aduan->store('aduan-siber', 'public');
                }

                // Create Aduan Siber
                $aduan = AduanSiber::create([
                    'aplikasi_id' => $validated['aplikasi_id'],
                    'jenis_aduan_id' => $validated['jenis_aduan_id'],
                    'judul_aduan' => $validated['judul_aduan'],
                    'deskripsi_aduan' => $validated['deskripsi_aduan'],
                    'foto_aduan' => $fotoPath,
                ]);

                // Create Pelapor
                $pelapor = AduanSiberPelapor::create([
                    'aduan_siber_id' => $aduan->id,
                    'nama_pengadu' => $validated['nama_pengadu'],
                    'email_pengadu' => $validated['email_pengadu'],
                    'no_telp_pengadu' => $validated['no_telp_pengadu'],
                ]);

                // Create initial progress
                ProgresAduanSiber::create([
                    'aduan_siber_id' => $aduan->id,
                    'status' => 'Diterima',
                    'catatan' => 'Aduan telah diterima dan sedang dalam proses verifikasi',
                ]);

                // Clear form
                $this->reset();
                
                session()->flash('success', 'Aduan Anda berhasil dikirim. Kami akan segera memprosesnya.');
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengirim aduan. Silakan coba lagi.');
        }
    }
}; ?>

<div>
    <section class="page-header-section ptb-100 gradient-overly-right" style="background: url('assets/img/hero-14.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-6">
                    <div class="page-header-content text-white">
                        <h1 class="text-white mb-2">Form Aduan Siber</h1>
                        <p class="lead">Laporkan insiden keamanan siber yang Anda temukan untuk membantu kami meningkatkan keamanan digital Kabupaten Cianjur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="breadcrumb-bar py-3 gray-light-bg border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="custom-breadcrumb">
                        <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0 pl-0">
                            <li class="list-inline-item breadcrumb-item">
                                <a class="text-decoration-none" href="{{ route('users.index') }}">Beranda</a>
                            </li>
                            <li class="list-inline-item breadcrumb-item active">Aduan Siber</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="submit-request-form ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-5">
                        <h2>Formulir Aduan Siber</h2>
                        <p class="lead">Silakan isi formulir berikut untuk melaporkan insiden keamanan siber yang Anda temukan.</p>
                    </div>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <form wire:submit.prevent="submitAduan" class="submit-request-form">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="aplikasi_id">Aplikasi yang Dilaporkan <span class="required">*</span></label>
                                    <select wire:model="aplikasi_id" id="aplikasi_id" class="form-control" required>
                                        <option value="">Pilih Aplikasi</option>
                                        @foreach($daftarAplikasi as $aplikasi)
                                            <option value="{{ $aplikasi->id }}">{{ $aplikasi->nama_aplikasi }}</option>
                                        @endforeach
                                    </select>
                                    @error('aplikasi_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="jenis_aduan_id">Jenis Aduan <span class="required">*</span></label>
                                    <select wire:model="jenis_aduan_id" id="jenis_aduan_id" class="form-control" required>
                                        <option value="">Pilih Jenis Aduan</option>
                                        @foreach($jenisAduan as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis_aduan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_aduan_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="nama_pengadu">Nama Lengkap <span class="required">*</span></label>
                                    <input wire:model="nama_pengadu" id="nama_pengadu" class="form-control" type="text" placeholder="Nama Anda" required>
                                    @error('nama_pengadu') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="judul_aduan">Judul Aduan <span class="required">*</span></label>
                                    <input wire:model="judul_aduan" id="judul_aduan" class="form-control" type="text" placeholder="Judul singkat aduan" required>
                                    @error('judul_aduan') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email_pengadu">Email</label>
                                    <input wire:model="email_pengadu" id="email_pengadu" class="form-control" type="email" placeholder="Email Anda">
                                    @error('email_pengadu') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="no_telp_pengadu">Nomor Telepon/WhatsApp</label>
                                    <input wire:model="no_telp_pengadu" id="no_telp_pengadu" class="form-control" type="tel" placeholder="Nomor telepon aktif">
                                    @error('no_telp_pengadu') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group input-file-wrap">
                                    <label for="foto_aduan">Bukti/Dokumentasi</label>
                                    <input wire:model="foto_aduan" id="foto_aduan" type="file" class="form-control" />
                                    <small class="text-muted">Unggah foto/screenshot (maks. 2MB)</small>
                                    @error('foto_aduan') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="deskripsi_aduan">Deskripsi Lengkap <span class="required">*</span></label>
                                    <textarea wire:model="deskripsi_aduan" id="deskripsi_aduan" class="form-control" placeholder="Jelaskan secara detail tentang aduan Anda" rows="6" required></textarea>
                                    <p class="small mt-2">Mohon jelaskan dengan detail kronologi kejadian, dampak yang terjadi, dan langkah-langkah yang sudah dilakukan.</p>
                                    @error('deskripsi_aduan') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="submit" class="btn primary-solid-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove>KIRIM ADUAN</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Mengirim...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>