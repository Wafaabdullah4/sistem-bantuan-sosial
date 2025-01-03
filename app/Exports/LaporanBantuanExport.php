<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanBantuanExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $laporanBantuans;

    public function __construct($laporanBantuans)
    {
        $this->laporanBantuans = $laporanBantuans;
    }

    public function collection()
    {
        // Mengambil data dan memformatnya sesuai kebutuhan
        $formattedData = $this->laporanBantuans->map(function($laporan) {
            return [
                $laporan->wilayah->nama_wilayah,     
                $laporan->program->nama_program,     
                $laporan->status,           
                $laporan->tanggal_penyaluran, 
                $laporan->jumlah_penerima,          
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'Wilayah',
            'Program',
            'Status',
            'Tanggal Penyaluran',
            'Jumlah Penerima',
        ];
    }

    public function styles($sheet)
    {
        // Styling untuk header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '0A7E8C'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Styling untuk baris data
        $sheet->getStyle('A2:E' . ($this->laporanBantuans->count() + 1))->applyFromArray([
            'font' => [
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            // Centering title and headers
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Bantuan';
    }
}
