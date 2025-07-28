<?php

namespace App\Exports;

use App\Models\SKPDModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkpdExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithStyles
{
    public function collection()
    {
        // Ambil data SKPD
        $data = SKPDModel::select('nama_skpd', 'website_skpd', 'is_active')
            ->get()
            ->map(function ($item, $key) {
                return [
                    'no' => $key + 1,
                    'nama_skpd' => $item->nama_skpd,
                    'website_skpd' => $item->website_skpd,
                    'status_website' => $item->is_active ? 'Aktif' : 'Tidak Aktif', // Konversi boolean ke string
                ];
            });

        // Tambahkan baris kosong dan keterangan di bawah data
        $data->push([]); // Baris kosong
        $data->push([
            'Tanggal Download: ' . now()->format('d F Y H:i:s'), // Tanggal download yang bisa dibaca
        ]);
        $data->push([
            'Sumber: https://katalog-aplikasi.cianjurkab.go.id/', // Sumber
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Daftar Website Pemerintah Daerah'], // Judul
            ['Tanggal Generate: ' . now()->format('d-m-Y H:i:s')], // Tanggal generate
            [], // Baris kosong
            ['No', 'Nama SKPD', 'Website SKPD', 'Status Website'], // Header kolom
        ];
    }

    public function title(): string
    {
        return 'Daftar Website';
    }

    public function startCell(): string
    {
        return 'A4'; // Mulai dari sel A4 untuk data
    }

    public function styles(Worksheet $sheet)
    {
        // Jumlah kolom yang digunakan (A, B, C, D)
        $lastColumn = 'D';

        // Style untuk judul
        $sheet->mergeCells("A1:{$lastColumn}1"); // Merge cell untuk judul
        $sheet->mergeCells("A2:{$lastColumn}2"); // Merge cell untuk tanggal generate

        // Style untuk judul
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true, // Bold judul
                'size' => 14,   // Ukuran font judul
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
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Tengah horizontal
            ],
        ]);

        // Style untuk keterangan di bawah tabel
        $lastRow = $sheet->getHighestRow(); // Ambil baris terakhir
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
