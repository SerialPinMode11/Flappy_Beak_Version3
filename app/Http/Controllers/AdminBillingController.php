<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use Illuminate\Http\Request;

class AdminBillingController extends Controller
{
    //admin-dashboard
    public function dashboard()
    {
        $totalSales = BillingInformation::where('status', 'completed')->sum('total_amount');
        $totalCustomers = BillingInformation::where('status', 'completed')->count();
        
        $monthlySales = BillingInformation::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('totalSales', 'totalCustomers', 'monthlySales'));
    }


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

    
}