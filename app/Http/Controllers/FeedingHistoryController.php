<?php

namespace App\Http\Controllers;

use App\Models\FeedingHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FeedingHistoryController extends Controller
{
    // Store feeding record from "Feed Now" button
    public function feedNow(Request $request)
    {
        $feeding = FeedingHistory::create([
            'fed_at' => now(),
            'fed_by' => 'JM Casabar', // If you have auth
            'is_manual' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feeding recorded successfully!',
            'data' => $feeding
        ]);
    }

    // Show history page
    public function index()
    {
        $histories = FeedingHistory::paginate(15);
        return view('history', compact('histories'));
    }

    // Store manual feeding record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fed_at' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $feeding = FeedingHistory::create([
            'fed_at' => $validated['fed_at'],
            'fed_by' => 'JM Casabar',
            'notes' => $validated['notes'] ?? null,
            'is_manual' => true
        ]);

        return redirect()->back()->with('success', 'Feeding history added successfully!');
    }

    // Soft delete
    public function destroy($id)
    {
        $feeding = FeedingHistory::findOrFail($id);
        $feeding->delete(); // Soft delete

        return redirect()->back()->with('success', 'History deleted successfully!');
    }
}