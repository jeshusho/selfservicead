<?php

namespace App\Exports;

use App\Models\Aduser;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;

class AdusersExport implements FromView,WithColumnFormatting, WithTitle, WithColumnWidths, WithStyles
{
    protected $data;
    protected $today;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $today)
    {
        $this->data = $data;
        $this->today = $today;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Aduser::all();
    // }

    public function view(): View
    {
        return view('exports.adusers', [
            'adusers' => $this->data,
            'today' => $this->today,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            // 'C' => NumberFormat::FORMAT_TEXT,
            // 'E' => 'dd/md/yyyy h:mm', //NumberFormat::FORMAT_DATE_DDMMYYYY, //'dd/md/yyyy h:mm',//NumberFormat::FORMAT_DATE_DDMMYYYY,
            // 'G' => NumberFormat::FORMAT_TEXT, //H
            // 'J' => NumberFormat::FORMAT_NUMBER_00 //K
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 40,
            'C' => 35,
            'D' => 42,
            'E' => 10,
            'F' => 10,
        ];
    }
/*
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],
        ];
    }
*/
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:F')->getFont()->setSize(10);
        $sheet->getStyle('A1:F3')->getFont()->setBold(true);
        $sheet->getStyle('A1:F3')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('A2:K2')->getFont()->getColor()->setARGB('FFFFFFFF');
        // $sheet->getStyle('A2:K2')->getFill()->setFillType('solid')->getStartColor()->setARGB('FF004684'); //Fill::FILL_SOLID
        // $sheet->getRowDimension('1')->setRowHeight(25);
        // $sheet->getStyle('C')->getAlignment()->setHorizontal('left');
        // $sheet->getStyle('G')->getAlignment()->setHorizontal('left');
        // $sheet->getStyle('A1')->getFont()->setBold(true);
        // $sheet->getStyle('A1')->getFont()->setSize(14);
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('A1')->getAlignment()->setVertical('center'); //Alignment::VERTICAL_CENTER
        // $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FF004684');

    }


    public function title(): string
    {
        return 'USUARIOS DEL AD';
    }
}
