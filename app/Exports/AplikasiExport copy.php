<?php

namespace App\Exports;

use App\Models\DaftarAplikasiModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AplikasiExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Ambil data aplikasi dengan join tabel terkait
        $data = DaftarAplikasiModel::join('jenis_aplikasi', 'daftar_aplikasi.jenis_aplikasi_id', '=', 'jenis_aplikasi.id')
            ->join('kategori_aplikasi', 'daftar_aplikasi.kategori_aplikasi_id', '=', 'kategori_aplikasi.id')
            ->join('daftar_skpd', 'daftar_aplikasi.skpd_id', '=', 'daftar_skpd.id')
            ->join('platform_aplikasi', 'daftar_aplikasi.platform_aplikasi_id', '=', 'platform_aplikasi.id')
            ->join('database_aplikasi', 'daftar_aplikasi.database_aplikasi_id', '=', 'database_aplikasi.id')
            ->join('framework_aplikasi', 'daftar_aplikasi.framework_aplikasi_id', '=', 'framework_aplikasi.id')
            ->join('bahasa_aplikasi', 'daftar_aplikasi.bahasa_aplikasi_id', '=', 'bahasa_aplikasi.id')
            ->join('pembuat_aplikasi', 'daftar_aplikasi.pembuat_aplikasi_id', '=', 'pembuat_aplikasi.id')
            ->select(
                'daftar_aplikasi.nama_aplikasi',
                'kategori_aplikasi.kategori_aplikasi as kategori',
                'jenis_aplikasi.jenis_aplikasi as jenis',
                'daftar_aplikasi.url_aplikasi as url',
                'daftar_skpd.alias_skpd as dinas',
                'platform_aplikasi.platform_aplikasi as platform',
                'bahasa_aplikasi.bahasa_aplikasi as bahasa',
                'pembuat_aplikasi.pembuat_aplikasi as pembuat',
                'database_aplikasi.database_aplikasi as database',
                'framework_aplikasi.framework_aplikasi as framework',
                'daftar_aplikasi.is_active',
                'daftar_aplikasi.is_featured'
            )
            ->get()
            ->map(function ($item, $key) {
                return [
                    'No' => $key + 1,
                    'Nama Aplikasi' => $item->nama_aplikasi,
                    'Kategori' => $item->kategori,
                    'Jenis' => $item->jenis,
                    'URL' => $item->url,
                    'Dinas Pengampu' => $item->dinas,
                    'Platform' => $item->platform,
                    'Bahasa' => $item->bahasa,
                    'Pembuat' => $item->pembuat,
                    'Database' => $item->database,
                    'Framework' => $item->framework,
                    'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
                    'Featured' => $item->is_featured ? 'Ya' : 'Tidak',
                ];
            });

        // Tambahkan baris kosong dan keterangan di bawah data
        $data->push([]); // Baris kosong
        $data->push([]); // Baris kosong
        $data->push([]); // Baris kosong
        $data->push([
            'Sumber: https://katalog-apps.cianjurkab.go.id/', // Sumber
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Daftar Aplikasi Pemerintah Daerah'], // Judul
            ['Tanggal Generate: ' . now()->format('d-m-Y H:i:s')], // Tanggal generate
            [], // Baris kosong
            [
                'No', 
                'Nama Aplikasi', 
                'Kategori', 
                'Jenis', 
                'URL', 
                'Dinas Pengampu', 
                'Platform', 
                'Bahasa', 
                'Pembuat', 
                'Database', 
                'Framework', 
                'Status', 
                'Featured'
            ], // Header kolom
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Jumlah kolom yang digunakan (A, B, C, D, E, F, G, H, I, J, K, L, M)
        $lastColumn = 'M';

        // Style untuk judul
        $sheet->mergeCells("A1:{$lastColumn}1"); // Merge cell untuk judul
        $sheet->mergeCells("A2:{$lastColumn}2"); // Merge cell untuk tanggal generate

        // Style untuk judul
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true, // Bold judul
                'size' => 16,   // Ukuran font judul
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Tengah horizontal
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Tengah vertikal
            ],
        ]);

        // Style untuk tanggal generate
        $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
            'font' => [
                'bold' => true, // Bold tanggal generate
                'size' => 12,   // Ukuran font tanggal generate
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Tengah horizontal
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Tengah vertikal
            ],
        ]);

        // Style untuk header kolom
        $sheet->getStyle("A4:{$lastColumn}4")->applyFromArray([
            'font' => [
                'bold' => true, // Bold header kolom
                'size' => 12,  // Ukuran font header kolom
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Tengah horizontal
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2'], // Warna background header (biru muda)
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Border tipis
                ],
            ],
        ]);

        // Style untuk data
        $lastRow = $sheet->getHighestRow(); // Ambil baris terakhir
        $sheet->getStyle("A4:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Border tipis
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Tengah horizontal
            ],
        ]);

        // Style untuk keterangan di bawah tabel
        $sheet->mergeCells("A{$lastRow}:{$lastColumn}{$lastRow}"); // Merge cell untuk keterangan
        $sheet->getStyle("A{$lastRow}:{$lastColumn}{$lastRow}")->applyFromArray([
            'font' => [
                'italic' => true, // Teks miring
            ],
        ]);

        // Auto size kolom
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
