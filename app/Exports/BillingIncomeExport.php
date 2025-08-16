<?php

namespace App\Exports;

use App\Models\BillingInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BillingIncomeExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $filters;
    protected $totalIncome;
    protected $recordCount;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Build query for completed billing records only
        $query = BillingInformation::where('status', 'completed');

        // Apply filters
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['customer_name'])) {
            $query->where('name', 'like', '%' . $this->filters['customer_name'] . '%');
        }

        if (!empty($this->filters['payment_method'])) {
            $query->where('payment_method', $this->filters['payment_method']);
        }

        $billingRecords = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate totals
        $this->totalIncome = $billingRecords->sum('total_amount');
        $this->recordCount = $billingRecords->count();

        // Add summary rows
        $summaryData = collect([
            (object)[
                'id' => '',
                'name' => '',
                'email' => '',
                'address' => '',
                'city' => '',
                'zip' => '',
                'payment_method' => '',
                'online_payment_method' => '',
                'reference_number' => '',
                'total_amount' => '',
                'status' => '',
                'created_at' => '',
                'summary_type' => 'spacer'
            ],
            (object)[
                'id' => 'SUMMARY',
                'name' => 'Total Completed Records:',
                'email' => $this->recordCount,
                'address' => '',
                'city' => '',
                'zip' => '',
                'payment_method' => '',
                'online_payment_method' => '',
                'reference_number' => '',
                'total_amount' => '',
                'status' => '',
                'created_at' => '',
                'summary_type' => 'count'
            ],
            (object)[
                'id' => '',
                'name' => 'Total Income Generated:',
                'email' => '',
                'address' => '',
                'city' => '',
                'zip' => '',
                'payment_method' => '',
                'online_payment_method' => '',
                'reference_number' => '',
                'total_amount' => $this->totalIncome,
                'status' => '',
                'created_at' => '',
                'summary_type' => 'total'
            ]
        ]);

        return $billingRecords->concat($summaryData);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Email',
            'Address',
            'City',
            'ZIP Code',
            'Payment Method',
            'Online Payment',
            'Reference Number',
            'Amount (₱)',
            'Status',
            'Date Created'
        ];
    }

    public function map($billing): array
    {
        // Handle summary rows
        if (isset($billing->summary_type)) {
            if ($billing->summary_type === 'spacer') {
                return ['', '', '', '', '', '', '', '', '', '', '', ''];
            } elseif ($billing->summary_type === 'count') {
                return [
                    $billing->id,
                    $billing->name,
                    $billing->email,
                    '', '', '', '', '', '', '', '', ''
                ];
            } elseif ($billing->summary_type === 'total') {
                return [
                    '', $billing->name, '', '', '', '', '', '', '',
                    '₱' . number_format($billing->total_amount, 2),
                    '', ''
                ];
            }
        }

        // Regular billing record
        return [
            $billing->id,
            $billing->name,
            $billing->email,
            $billing->address,
            $billing->city,
            $billing->zip,
            ucfirst($billing->payment_method),
            $billing->online_payment_method ? ucfirst($billing->online_payment_method) : '',
            $billing->reference_number ?? '',
            '₱' . number_format($billing->total_amount, 2),
            ucfirst($billing->status),
            $billing->created_at->format('M d, Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        return [
            // Header row styling
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ],
            
            // Summary rows styling
            ($lastRow - 2) => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E5E7EB']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ],
            ($lastRow - 1) => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E5E7EB']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ],
            $lastRow => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '10B981']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THICK]]
            ],
            
            // All data borders
            'A1:L' . $lastRow => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 20,  // Customer Name
            'C' => 25,  // Email
            'D' => 30,  // Address
            'E' => 15,  // City
            'F' => 10,  // ZIP
            'G' => 15,  // Payment Method
            'H' => 15,  // Online Payment
            'I' => 18,  // Reference Number
            'J' => 15,  // Amount
            'K' => 12,  // Status
            'L' => 18,  // Date
        ];
    }

    public function title(): string
    {
        $title = 'Income Sales Report';
        
        if (!empty($this->filters['date_from']) && !empty($this->filters['date_to'])) {
            $title .= ' (' . $this->filters['date_from'] . ' to ' . $this->filters['date_to'] . ')';
        }
        
        return $title;
    }
}
