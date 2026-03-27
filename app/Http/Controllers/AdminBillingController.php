<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use App\Models\Booking;
use App\Models\ContactForm;
use App\Models\DuckProducts;
use App\Models\Expense;
use App\Models\FeedInventory;
use App\Models\WineProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\BillingIncomeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AdminBillingController extends Controller
{
    public function latestCompletedNotification()
    {
        $latest = BillingInformation::where('status', 'completed')
            ->latest()
            ->first();

        if (!$latest) {
            return response()->json(['latest' => null]);
        }

        return response()->json([
            'latest' => [
                'id' => $latest->id,
                'name' => $latest->name,
                'email' => $latest->email,
                'total_amount' => (float) $latest->total_amount,
                'created_at' => optional($latest->created_at)->toDateTimeString(),
            ],
        ]);
    }

    //admin-dashboard
    public function dashboard()
    {
        // Core order metrics
        $totalSales = BillingInformation::where('status', 'completed')->sum('total_amount');
        $totalOrders = BillingInformation::count();
        $completedCustomers = BillingInformation::where('status', 'completed')->count();
        $pendingOrders = BillingInformation::where('status', 'pending')->count();
        $processingOrders = BillingInformation::where('status', 'processing')->count();
        $cancelledOrders = BillingInformation::where('status', 'cancelled')->count();

        // Finance summary
        $todayRevenue = BillingInformation::where('status', 'completed')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_amount');
        $totalExpenses = Expense::sum('amount');
        $netRevenue = $totalSales - $totalExpenses;

        // Monthly sales data for chart
        $monthlySales = BillingInformation::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Orders by status for chart
        $purchasesByStatus = BillingInformation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Module summaries
        $duckProductCount = DuckProducts::count();
        $wineProductCount = WineProduct::count();
        $totalProducts = $duckProductCount + $wineProductCount;
        $lowStockProducts = DuckProducts::where('product_stock', '<=', 5)->count()
            + WineProduct::where('product_stock', '<=', 5)->count();

        $contactMessages = ContactForm::count();
        $recentContactMessages = ContactForm::whereDate('created_at', '>=', now()->subDays(7)->toDateString())->count();

        $incubationTotal = Booking::count();
        $incubationActive = Booking::whereIn('status', ['pending', 'confirmed', 'in_progress', 'candling', 'lockdown', 'hatching'])->count();

        $feedInventoryCount = FeedInventory::count();
        $feedLowStock = FeedInventory::whereIn('status', ['Low Stock', 'Out of Stock'])->count();

        // Recent activity sections
        $recentOrders = BillingInformation::latest()->take(5)->get();
        $recentExpenses = Expense::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'completedCustomers',
            'pendingOrders',
            'processingOrders',
            'cancelledOrders',
            'todayRevenue',
            'totalExpenses',
            'netRevenue',
            'monthlySales',
            'purchasesByStatus',
            'totalProducts',
            'duckProductCount',
            'wineProductCount',
            'lowStockProducts',
            'contactMessages',
            'recentContactMessages',
            'incubationTotal',
            'incubationActive',
            'feedInventoryCount',
            'feedLowStock',
            'recentOrders',
            'recentExpenses'
        ));
    }

    // Rest of your controller methods...

    public function index()
    {
        $billingInfo = BillingInformation::latest()->paginate(10);
        return view('admin.billing.index', compact('billingInfo'));
    }

    public function trash()
    {
        $billingInfo = BillingInformation::onlyTrashed()->latest()->paginate(10);
        return view('admin.billing.trash', compact('billingInfo'));
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
            'status' => 'required|string|in:pending,preparing,processing,out_for_delivery,delivered,completed,cancelled',
        ]);

        $billing = BillingInformation::findOrFail($id);
        $data = $request->all();

        // If items JSON is provided, try to decode it to an array
        if (!empty($data['items'])) {
            $decoded = json_decode($data['items'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $data['items'] = $decoded;
            } else {
                // Keep original value so the user can correct it; don't break update
                unset($data['items']);
            }
        }

        $billing->update($data);

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

    public function destroy($id)
    {
        $billing = BillingInformation::findOrFail($id);
        $billing->delete();

        return redirect()->route('admin.billing.index')
            ->with('success', 'Billing record moved to trash.');
    }

    public function restore($id)
    {
        $billing = BillingInformation::onlyTrashed()->findOrFail($id);
        $billing->restore();

        return redirect()->route('admin.billing.trash')
            ->with('success', 'Billing record restored successfully.');
    }

    public function forceDelete($id)
    {
        $billing = BillingInformation::onlyTrashed()->findOrFail($id);
        $billing->forceDelete();

        return redirect()->route('admin.billing.trash')
            ->with('success', 'Billing record permanently deleted.');
    }
}
