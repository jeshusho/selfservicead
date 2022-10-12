<?php

namespace App\Exports;

use App\Models\Message;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;

class MessagesExport implements FromView,WithColumnFormatting, WithTitle, WithColumnWidths, WithStyles
{
    protected $data;
    protected $date_ini;
    protected $date_end;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $date_ini, $date_end)
    {
        $this->data = $data;
        $this->date_ini = $date_ini;
        $this->date_end = $date_end;
    }


    public function view(): View
    {
        return view('exports.messages', [
            'messages' => $this->data,
            'date_ini' => $this->date_ini,
            'date_end' => $this->date_end,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat ::FORMAT_NUMBER
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
            'B' => 35,
            'C' => 25,
            'D' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:D')->getFont()->setSize(10);
        $sheet->getStyle('A1:D3')->getFont()->setBold(true);
        $sheet->getStyle('A1:D3')->getAlignment()->setHorizontal('center');
    }


    public function title(): string
    {
        return 'NOTIFICACIONES ENVIADAS';
    }
}
