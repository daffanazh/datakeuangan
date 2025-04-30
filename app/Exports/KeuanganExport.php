<?php

namespace App\Exports;

use App\Models\keuangan;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeuanganExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($keuangan): array
    {
        return [
            $keuangan->user->keluarga->nama_keluarga ?? '-',
            $keuangan->user->keluarga->email_keluarga ?? '-',
            $keuangan->user->name ?? '-',
            $keuangan->jumlah_transfer,
            $keuangan->bulan,
            $keuangan->foto_bukti,
            $keuangan->waktu_upload,
            $keuangan->penerima,
            $keuangan->deskripsi,
        ];
    }

    public function collection()
    {
        return keuangan::with(['user.keluarga'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Keluarga',
            'Email Keluarga',
            'Nama Anak',
            'Jumlah Transfer',
            'Bulan',
            'Foto Bukti',
            'Waktu Upload',
            'Penerima',
            'Deskripsi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur seluruh kolom A sampai I dan baris 1 sampai jumlah data + 1 (karena ada heading)
        $lastRow = keuangan::count() + 1;

        $sheet->getStyle("A1:I{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'size' => 11,
            ]
        ]);

        // Bold untuk header saja
        $sheet->getStyle("A1:I1")->getFont()->setBold(true);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 20,
            'D' => 15,
            'E' => 30,
            'F' => 40,
            'G' => 20,
            'H' => 20,
            'I' => 30,
        ];
    }
}

