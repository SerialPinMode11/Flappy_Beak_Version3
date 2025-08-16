<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\BillingIncomeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AdminBillingController extends Controller
{
    //admin-dashboard
    public function dashboard()
    {
        // Total sales from completed orders
        $totalSales = BillingInformation::where('status', 'completed')->sum('total_amount');
        
        // Count all customers
        $totalCustomers = BillingInformation::count();
        
        // Count completed customers
        $completedCustomers = BillingInformation::where('status', 'completed')->count();
        
        // Monthly sales data
        $monthlySales = BillingInformation::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // If no monthly sales data, create dummy data for testing
        if ($monthlySales->isEmpty()) {
            $monthlySales = collect([
                ['month' => 3, 'total' => 1650.00]
            ]);
        }
            
        // Get successful purchases by customer (completed status)
        $successfulPurchases = BillingInformation::where('status', 'completed')
            ->select('name', DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('name')
            ->orderBy('total_amount', 'desc')
            ->get();
            
        // Get all purchases by customer (all statuses)
        $allPurchases = BillingInformation::select('name', 'status', DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('name', 'status')
            ->orderBy('name')
            ->get();
            
        // Get unique customer names for the charts - FIXED THIS LINE
        $customerNames = BillingInformation::distinct('name')->pluck('name')->toArray();
        
        // Get purchase counts by status
        $purchasesByStatus = BillingInformation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
            
        // If no status data, create dummy data for testing
        if ($purchasesByStatus->isEmpty()) {
            $purchasesByStatus = collect([
                ['status' => 'completed', 'count' => $completedCustomers],
                ['status' => 'pending', 'count' => $totalCustomers - $completedCustomers]
            ]);
        }

        // Debug the data being passed to the view
        // dd($customerNames, $allPurchases);

        return view('admin.dashboard', compact(
            'totalSales', 
            'totalCustomers', 
            'completedCustomers', 
            'monthlySales',
            'successfulPurchases',
            'allPurchases',
            'customerNames',
            'purchasesByStatus'
        ));
    }

    // Rest of your controller methods...

    public function index()
    {
        $billingInfo = BillingInformation::latest()->paginate(10);
        return view('admin.billing.index', compact('billingInfo'));
    }

    public function show($id)
    {
        $billing = BillingInformation::findOrFail($id);
        return view('admin.billing.show', compact('billing'));
    }

    public function edit($id)
    {
        $billing = BillingInformation::findOrFail($id);
        return view('admin.billing.edit', compact('billing'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $billing = BillingInformation::findOrFail($id);
        $billing->update($request->all());

        return redirect()->route('admin.billing.index')
            ->with('success', 'Billing information updated successfully');
    }

    public function export(Request $request)
    {
        try {
            $request->validate([
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'customer_name' => 'nullable|string|max:255',
                'payment_method' => 'nullable|string|in:cash,online,card',
            ]);

            // Build query for completed billing records only
            $query = BillingInformation::where('status', 'completed');

            // Apply filters
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('customer_name')) {
                $query->where('name', 'like', '%' . $request->customer_name . '%');
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            // Generate filename with filters
            $filename = 'income_sales_report_' . now()->format('Y-m-d_H-i-s');
            
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $filename .= '_' . $request->date_from . '_to_' . $request->date_to;
            } elseif ($request->filled('date_from')) {
                $filename .= '_from_' . $request->date_from;
            } elseif ($request->filled('date_to')) {
                $filename .= '_until_' . $request->date_to;
            }

            if ($request->filled('customer_name')) {
                $filename .= '_' . str_replace(' ', '_', $request->customer_name);
            }

            if ($request->filled('payment_method')) {
                $filename .= '_' . $request->payment_method;
            }

            $filename .= '.xlsx';

            return Excel::download(new BillingIncomeExport($request->all()), $filename);

        } catch (\Exception $e) {
            Log::error('Billing export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Export failed. Please try again.');
        }
    }
}
