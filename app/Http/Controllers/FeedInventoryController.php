<?php

namespace App\Http\Controllers;

use App\Models\FeedInventory;
use Illuminate\Http\Request;

class FeedInventoryController extends Controller
{
    // Show inventory page
    public function index()
    {
        $feeds = FeedInventory::orderBy('feed_name')->get();
        
        // Calculate summary statistics
        $totalStock = $feeds->sum('quantity');
        $lowStockCount = $feeds->where('status', 'Low Stock')->count();
        $monthlyCost = $feeds->sum(function($feed) {
            return $feed->quantity * $feed->cost_per_unit;
        });
        
        return view('inventory', compact('feeds', 'totalStock', 'lowStockCount', 'monthlyCost'));
    }

    // Store new feed
    public function store(Request $request)
    {
        $validated = $request->validate([
            'feed_name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        FeedInventory::create($validated);

        return redirect()->back()->with('success', 'Feed added successfully!');
    }

    // Update existing feed
    public function update(Request $request, $id)
    {
        $feed = FeedInventory::findOrFail($id);

        $validated = $request->validate([
            'feed_name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $feed->update($validated);

        return redirect()->back()->with('success', 'Feed updated successfully!');
    }

    // Delete feed (only if quantity is 0)
    public function destroy($id)
    {
        $feed = FeedInventory::findOrFail($id);

        if ($feed->quantity > 0) {
            return redirect()->back()->with('error', 'Cannot delete feed with quantity greater than 0. Please reduce quantity to 0 first.');
        }

        $feed->delete();

        return redirect()->back()->with('success', 'Feed deleted successfully!');
    }
}