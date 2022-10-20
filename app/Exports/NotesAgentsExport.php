<?php

namespace App\Exports;

use App\Models\NoteAgent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotesAgentsExport implements  FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    public function __construct($data)
    {

        $this->data = $data;
    }
    public function array(): array
    {
        return $this->data;
    }
    public function headings(): array
    {
        return [
            'formation',
            'agent',
            'note',
            'date',
            'activite',
            'service',
            'site',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'color' => ['argb' => 'ffffff']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => '3471eb'],
                ],],
        ];
    }
}
