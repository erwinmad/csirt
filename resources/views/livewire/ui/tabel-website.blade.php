<?php

use Livewire\Volt\Component;
use App\Models\SKPDModel;
use Illuminate\Support\Facades\DB;

new class extends Component {

    public $cariPerangkatDaerah = '';
    public $skpd_id = '';
    public $statusFilter = '';

    public function with(): array
    {
        return [
            'kat_skpd'     => DB::table('kategori_skpd')->get(),

            'website'      => SKPDModel::select('id', 'nama_skpd', 'website_skpd', 'is_active','alias_skpd')
                            ->when($this->cariPerangkatDaerah, function ($query) {
                                return $query->where('nama_skpd', 'like', '%'.$this->cariPerangkatDaerah.'%');
                            })
                            ->when($this->skpd_id, function ($query) {
                                return $query->where('skpd_id', 'like', '%'.$this->skpd_id.'%');
                            })
                            ->when($this->statusFilter !== '', function ($query) {
                                return $query->where('is_active', $this->statusFilter);
                            })
                            ->latest()
                            ->paginate(10),
        ];
    }
}; ?>

<div class="col-xl-9 stretch-card grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Website</h4>
            <p class="card-description">di Lingkungan Pemerintah Kabupaten Cianjur</p>
            
            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live="cariPerangkatDaerah" class="form-control" placeholder="Cari Perangkat Daerah...">
                </div>
                <div class="col-md-4">
                    <select wire:model.live="skpd_id" class="form-control">
                        <option value="">Pilih Kategori SKPD</option>
                        <option value="">Pilih Jenis PD</option>
                        <option value="Sekretariat">Sekretariat</option>
                        <option value="Badan">Badan</option>
                        <option value="Dinas">Dinas</option>
                        <option value="Kecamatan">Kecamatan</option>
                        <option value="Puskesmas">Puskesmas</option>
                        <option value="Satuan">Satuan</option>
                        <option value="BLUD">BLUD</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select wire:model.live="statusFilter" class="form-control">
                        <option value="">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <!-- End Filter Section -->

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Perangkat Daerah</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($website as $row)
                            <tr>
                                <td> {{ ($website->currentPage() - 1) * $website->perPage() + $loop->iteration }}</td>
                                <td>{{ $row->alias_skpd }}</td>
                                <td>{{ $row->website_skpd }}</td>
                                <td>
                                    @if ($row->is_active == 1)
                                        <label class="badge badge-success">
                                            <i class="mdi mdi-check"></i> Aktif
                                        </label>
                                    @else
                                        <label class="badge badge-danger">
                                            <i class="mdi mdi-close"></i> Tidak Aktif
                                        </label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $row->website_skpd }}" class="text-decoration-none">
                                        <label class="badge badge-danger">
                                            <i class="mdi mdi-link"></i> Visit
                                        </label>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $website->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
