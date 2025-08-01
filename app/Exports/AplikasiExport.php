<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\DaftarAplikasiModel;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AplikasiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Query dasar dengan join tabel terkait
        $query = DaftarAplikasiModel::join('jenis', 'daftar_aplikasi.jenis_id', '=', 'jenis.id')
            ->join('kategori_aplikasi', 'daftar_aplikasi.kategori_aplikasi_id', '=', 'kategori_aplikasi.id')
            ->join('jenis_aplikasi', 'daftar_aplikasi.jenis_aplikasi_id', '=', 'jenis_aplikasi.id')
            ->join('daftar_skpd', 'daftar_aplikasi.skpd_id', '=', 'daftar_skpd.id')
            ->join('platform_aplikasi', 'daftar_aplikasi.platform_aplikasi_id', '=', 'platform_aplikasi.id')
            ->join('database_aplikasi', 'daftar_aplikasi.database_aplikasi_id', '=', 'database_aplikasi.id')
            ->join('framework_aplikasi', 'daftar_aplikasi.framework_aplikasi_id', '=', 'framework_aplikasi.id')
            ->join('bahasa_aplikasi', 'daftar_aplikasi.bahasa_aplikasi_id', '=', 'bahasa_aplikasi.id')
            ->join('pembuat_aplikasi', 'daftar_aplikasi.pembuat_aplikasi_id', '=', 'pembuat_aplikasi.id')
            ->select(
                'daftar_aplikasi.nama_aplikasi',
                'daftar_aplikasi.tahun_pembuatan',
                'kategori_aplikasi.kategori_aplikasi as kategori',
                'jenis_aplikasi.jenis_aplikasi as jenis_aplikasi',
                'jenis.nama_jenis as jenis',
                'daftar_aplikasi.url_aplikasi as url',
                'daftar_skpd.alias_skpd as dinas',
                'platform_aplikasi.platform_aplikasi as platform',
                'bahasa_aplikasi.bahasa_aplikasi as bahasa',
                'pembuat_aplikasi.pembuat_aplikasi as pembuat',
                'database_aplikasi.database_aplikasi as database',
                'framework_aplikasi.framework_aplikasi as framework',
                'daftar_aplikasi.is_active',
                'daftar_aplikasi.is_featured',
                'daftar_aplikasi.is_integrated'
            );

        // Terapkan filter berdasarkan parameter yang diberikan
        if (!empty($this->filters['nama'])) {
            $query->where('daftar_aplikasi.nama_aplikasi', 'like', '%'.$this->filters['nama'].'%');
        }

        if (!empty($this->filters['bahasa'])) {
            $query->where('bahasa_aplikasi.id', $this->filters['bahasa']);
        }

        if (!empty($this->filters['pembuat'])) {
            $query->where('pembuat_aplikasi.id', $this->filters['pembuat']);
        }

        if (!empty($this->filters['framework'])) {
            $query->where('framework_aplikasi.id', $this->filters['framework']);
        }

        if (!empty($this->filters['jenis'])) {
            $query->where('jenis.id', $this->filters['jenis']);
        }

        if (!empty($this->filters['jenis_aplikasi'])) {
            $query->where('jenis_aplikasi.id', $this->filters['jenis_aplikasi']);
        }

        if (!empty($this->filters['kategori'])) {
            $query->where('kategori_aplikasi.id', $this->filters['kategori']);
        }

        if (!empty($this->filters['platform'])) {
            $query->where('platform_aplikasi.id', $this->filters['platform']);
        }

        if (!empty($this->filters['database'])) {
            $query->where('database_aplikasi.id', $this->filters['database']);
        }

        if (!empty($this->filters['skpd'])) {
            $query->where('daftar_skpd.id', $this->filters['skpd']);
        }

        if (!empty($this->filters['tahun_pembuatan'])) {
            $query->where('daftar_aplikasi.tahun_pembuatan', $this->filters['tahun_pembuatan']);
        }

        // Ambil data dengan filter yang diterapkan
        $data = $query->get()
            ->map(function ($item, $key) {
                return [
                    'No' => $key + 1,
                    'Nama Aplikasi' => $item->nama_aplikasi,
                    'Jenis' => $item->jenis,
                    'Jenis Aplikasi' => $item->jenis_aplikasi,
                    'Kategori' => $item->kategori,
                    'URL' => $item->url,
                    'Dinas Pengampu' => $item->dinas,
                    'Platform' => $item->platform,
                    'Bahasa' => $item->bahasa,
                    'Pembuat' => $item->pembuat,
                    'Tahun Pembuatan' => $item->tahun_pembuatan,
                    'Database' => $item->database,
                    'Framework' => $item->framework,
                    'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
                    'Featured' => $item->is_featured ? 'Ya' : 'Tidak',
                    'Terintegrasi' => $item->is_integrated ? 'Ya' : 'Tidak',
                ];
            });

        // Tambahkan baris kosong dan keterangan di bawah data
        $data->push([]); // Baris kosong
        $data->push([]); // Baris kosong
        $data->push([]); // Baris kosong
        $data->push([
            'Sumber: https://csirt.cianjurkab.go.id/', // Sumber
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Daftar Aplikasi Pemerintah Daerah'], // Judul
            ['Tanggal Generate: ' . now()->format('d-m-Y H:i:s')], // Tanggal generate
            ['Filter yang digunakan: ' . $this->getAppliedFiltersText()], // Filter yang digunakan
            [], // Baris kosong
            [
                'No', 
                'Nama Aplikasi', 
                'Jenis', 
                'Jenis Aplikasi',
                'Kategori', 
                'URL', 
                'Dinas Pengampu', 
                'Platform', 
                'Bahasa', 
                'Pembuat', 
                'Tahun Pembuatan',
                'Database', 
                'Framework', 
                'Status', 
                'Featured',
                'Terintegrasi'
            ], // Header kolom
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Jumlah kolom yang digunakan (A-O)
        $lastColumn = 'P';

        // Style untuk judul
        $sheet->mergeCells("A1:{$lastColumn}1"); // Merge cell untuk judul
        $sheet->mergeCells("A2:{$lastColumn}2"); // Merge cell untuk tanggal generate
        $sheet->mergeCells("A3:{$lastColumn}3"); // Merge cell untuk filter yang digunakan

        // Style untuk judul
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style untuk tanggal generate
        $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style untuk filter yang digunakan
        $sheet->getStyle("A3:{$lastColumn}3")->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style untuk header kolom
        $sheet->getStyle("A5:{$lastColumn}5")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Style untuk data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A5:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style untuk keterangan di bawah tabel
        $sheet->mergeCells("A{$lastRow}:{$lastColumn}{$lastRow}");
        $sheet->getStyle("A{$lastRow}:{$lastColumn}{$lastRow}")->applyFromArray([
            'font' => [
                'italic' => true,
            ],
        ]);

        // Auto size kolom
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    /**
     * Generate text for applied filters
     */
    protected function getAppliedFiltersText(): string
    {
        $filters = [];
        
        if (!empty($this->filters['nama'])) {
            $filters[] = 'Nama: ' . $this->filters['nama'];
        }
        
        if (!empty($this->filters['bahasa'])) {
            $filters[] = 'Bahasa: ' . $this->getFilterLabel('bahasa_aplikasi', $this->filters['bahasa']);
        }
        
        if (!empty($this->filters['pembuat'])) {
            $filters[] = 'Pembuat: ' . $this->getFilterLabel('pembuat_aplikasi', $this->filters['pembuat']);
        }

        if (!empty($this->filters['tahun_pembuatan'])) {
            $filters[] = 'Tahun: ' . $this->filters['tahun_pembuatan'];
        }
        
        if (!empty($this->filters['framework'])) {
            $filters[] = 'Framework: ' . $this->getFilterLabel('framework_aplikasi', $this->filters['framework']);
        }
        
        if (!empty($this->filters['jenis'])) {
            $filters[] = 'Jenis: ' . $this->getFilterLabel('jenis', $this->filters['jenis']);
        }
        
        if (!empty($this->filters['jenis_aplikasi'])) {
            $filters[] = 'Jenis Aplikasi: ' . $this->getFilterLabel('jenis_aplikasi', $this->filters['jenis_aplikasi']);
        }
        
        if (!empty($this->filters['kategori'])) {
            $filters[] = 'Kategori: ' . $this->getFilterLabel('kategori_aplikasi', $this->filters['kategori']);
        }
        
        if (!empty($this->filters['platform'])) {
            $filters[] = 'Platform: ' . $this->getFilterLabel('platform_aplikasi', $this->filters['platform']);
        }
        
        if (!empty($this->filters['database'])) {
            $filters[] = 'Database: ' . $this->getFilterLabel('database_aplikasi', $this->filters['database']);
        }
        
        if (!empty($this->filters['skpd'])) {
            $filters[] = 'SKPD: ' . $this->getFilterLabel('daftar_skpd', $this->filters['skpd']);
        }

        return empty($filters) ? 'Semua Data' : implode(', ', $filters);
    }

    /**
     * Get label for filter value
     */
    protected function getFilterLabel(string $table, int $id): string
    {
        $column = match($table) {
            'jenis' => 'nama_jenis',
            'jenis_aplikasi' => 'jenis_aplikasi',
            'kategori_aplikasi' => 'kategori_aplikasi',
            'platform_aplikasi' => 'platform_aplikasi',
            'database_aplikasi' => 'database_aplikasi',
            'framework_aplikasi' => 'framework_aplikasi',
            'bahasa_aplikasi' => 'bahasa_aplikasi',
            'pembuat_aplikasi' => 'pembuat_aplikasi',
            'daftar_skpd' => 'alias_skpd',
            default => 'nama'
        };

        $result = DB::table($table)->where('id', $id)->first();
        return $result ? $result->{$column} : 'Unknown';
    }
}