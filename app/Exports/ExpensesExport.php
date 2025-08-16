<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExpensesExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;
    protected $category;

    public function __construct($startDate = null, $endDate = null, $category = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->category = $category;
    }

    public function collection()
    {
        $query = Expense::query();

        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        return $query->select([
            'id',
            'expense_type',
            'description',
            'amount',
            'date',
            'category',
            'notes',
            'created_at'
        ])->get()->map(function ($expense) {
            return [
                'ID' => $expense->id,
                'Expense Type' => $expense->expense_type,
                'Description' => $expense->description,
                'Amount' => '₱' . number_format($expense->amount, 2),
                'Date' => date('M d, Y', strtotime($expense->date)),
                'Category' => $expense->category,
                'Notes' => $expense->notes ?? 'N/A',
                'Created At' => $expense->created_at->format('M d, Y H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Expense Type',
            'Description',
            'Amount',
            'Date',
            'Category',
            'Notes',
            'Created At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3B82F6'],
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, // Amount column as text to preserve formatting
        ];
    }
}