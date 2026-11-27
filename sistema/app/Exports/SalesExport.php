<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Exporta a Excel las mismas ventas que se ven en el reporte (ya filtradas en ReportController)
class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle, WithEvents
{
    public function __construct(private Collection $sales)
    {
    }

    // Filas del archivo
    public function collection(): Collection
    {
        return $this->sales;
    }

    // Primera fila: los títulos de las columnas
    public function headings(): array
    {
        return ['N.°', 'Fecha', 'Cliente', 'DNI', 'Vendedor', 'IGV (S/)', 'Total (S/)'];
    }

    // Qué columnas se escriben por cada venta
    public function map(mixed $sale): array
    {
        return [
            str_pad($sale->id, 6, '0', STR_PAD_LEFT),
            $sale->date->format('d/m/Y H:i'),
            $sale->customer->name,
            $sale->customer->dni,
            $sale->user->name,
            (float) $sale->igv,
            (float) $sale->total,
        ];
    }

    // Encabezado en negrita, letra blanca y fondo con el color del sistema
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FF0A41']],
            ],
        ];
    }

    // Nombre de la hoja
    public function title(): string
    {
        return 'Ventas';
    }

    // Al terminar la hoja se agrega una fila con los totales
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $row = $this->sales->count() + 2; // +1 por el encabezado y +1 para la fila siguiente

                $sheet->setCellValue("E{$row}", 'TOTALES');
                $sheet->setCellValue("F{$row}", $this->sales->sum('igv'));
                $sheet->setCellValue("G{$row}", $this->sales->sum('total'));
                $sheet->getStyle("E{$row}:G{$row}")->getFont()->setBold(true);
                $sheet->getStyle("F2:G{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
            },
        ];
    }
}
