<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class IncubationBookingsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $dateFrom;
    protected $dateTo;
    protected $serviceType;
    protected $bookings;
    protected $totalIncome;
    protected $completedCount;

    public function __construct($dateFrom = null, $dateTo = null, $serviceType = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->serviceType = $serviceType;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Build query
        $query = Booking::query();

        // Apply filters
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        if ($this->serviceType) {
            $query->where('service_type', $this->serviceType);
        }

        // Get all bookings for the report
        $this->bookings = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals for completed bookings only
        $completedBookings = $this->bookings->where('status', 'completed');
        $this->totalIncome = $completedBookings->sum('total_price');
        $this->completedCount = $completedBookings->count();

        // Prepare data for export
        $data = collect();

        // Add header information
        $data->push([
            'FLAPPY-BEAK INCUBATION SERVICES REPORT',
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Generated on: ' . now()->format('F d, Y g:i A'),
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        
        if ($this->dateFrom || $this->dateTo) {
            $dateRange = 'Period: ';
            if ($this->dateFrom && $this->dateTo) {
                $dateRange .= date('M d, Y', strtotime($this->dateFrom)) . ' to ' . date('M d, Y', strtotime($this->dateTo));
            } elseif ($this->dateFrom) {
                $dateRange .= 'From ' . date('M d, Y', strtotime($this->dateFrom));
            } else {
                $dateRange .= 'Until ' . date('M d, Y', strtotime($this->dateTo));
            }
            $data->push([$dateRange, '', '', '', '', '', '', '', '', '', '', '']);
        }

        if ($this->serviceType) {
            $serviceTypes = [
                'jm_casabar' => 'JM Casabar Formula',
                'custom' => 'Custom Formula',
                'experimental' => 'Experimental Formula',
                'world_based' => 'World-Based Formula',
            ];
            $data->push(['Service Type: ' . ($serviceTypes[$this->serviceType] ?? $this->serviceType), '', '', '', '', '', '', '', '', '', '', '']);
        }

        $data->push(['', '', '', '', '', '', '', '', '', '', '', '']); // Empty row

        // Add summary information
        $data->push([
            'SUMMARY',
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Total Bookings: ' . $this->bookings->count(),
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Completed Bookings: ' . $this->completedCount,
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Total Income (Completed Only): ₱' . number_format($this->totalIncome, 2),
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '']); // Empty row

        // Add column headers
        $data->push([
            'Reference',
            'Customer Name',
            'Email',
            'Phone',
            'Service Type',
            'Eggs',
            'Start Date',
            'Status',
            'Total Price',
            'Deposit Paid',
            'Balance Paid',
            'Created Date'
        ]);

        // Add booking data
        foreach ($this->bookings as $booking) {
            $data->push([
                $booking->booking_reference,
                $booking->name,
                $booking->email,
                $booking->phone,
                $booking->service_type_name,
                $booking->egg_quantity,
                $booking->start_date ? $booking->start_date->format('M d, Y') : 'Not set',
                $booking->status_name,
                $booking->total_price ? '₱' . number_format($booking->total_price, 2) : '₱0.00',
                $booking->deposit_paid ? 'Yes' : 'No',
                $booking->balance_paid ? 'Yes' : 'No',
                $booking->created_at->format('M d, Y')
            ]);
        }

        // Add footer totals
        $data->push(['', '', '', '', '', '', '', '', '', '', '', '']); // Empty row
        $data->push([
            'TOTALS',
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Total Records: ' . $this->bookings->count(),
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Completed Records: ' . $this->completedCount,
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
        $data->push([
            'Total Income: ₱' . number_format($this->totalIncome, 2),
            '', '', '', '', '', '', '', '', '', '', ''
        ]);

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return []; // We're handling headers in the collection method
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $headerRow = 11 + ($this->dateFrom || $this->dateTo ? 1 : 0) + ($this->serviceType ? 1 : 0);

        return [
            // Title styling
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => '1f2937']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f3f4f6']
                ]
            ],

            // Date and filter info styling
            '2:5' => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'color' => ['rgb' => '6b7280']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ]
            ],

            // Summary section styling
            '7:10' => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => '1f2937']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f9fafb']
                ]
            ],

            // Header row styling
            $headerRow => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'ffffff']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1f2937']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Data rows styling
            ($headerRow + 1) . ':' . ($lastRow - 5) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'e5e7eb']
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],

            // Footer totals styling
            ($lastRow - 4) . ':' . $lastRow => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => '1f2937']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f3f4f6']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Reference
            'B' => 25, // Customer Name
            'C' => 30, // Email
            'D' => 15, // Phone
            'E' => 25, // Service Type
            'F' => 10, // Eggs
            'G' => 15, // Start Date
            'H' => 20, // Status
            'I' => 15, // Total Price
            'J' => 12, // Deposit Paid
            'K' => 12, // Balance Paid
            'L' => 15, // Created Date
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Incubation Bookings Report';
    }
}
