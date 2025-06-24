<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;


class IncubationAdminController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->input('status');
        $serviceType = $request->input('service_type');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $search = $request->input('search');
        
        // Start query
        $bookings = Booking::query();
        
        // Apply filters
        if ($status) {
            $bookings->where('status', $status);
        }
        
        if ($serviceType) {
            $bookings->where('service_type', $serviceType);
        }
        
        if ($dateFrom) {
            $bookings->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $bookings->whereDate('created_at', '<=', $dateTo);
        }
        
        if ($search) {
            $bookings->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $bookings = $bookings->orderBy('created_at', 'desc')->paginate(10);
        
        // Get counts for dashboard
        $counts = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'active' => Booking::whereIn('status', ['confirmed', 'in_progress', 'candling', 'lockdown', 'hatching'])->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        
        // Get service types for filter dropdown
        $serviceTypes = [
            'jm_casabar' => 'JM Casabar Formula',
            'custom' => 'Custom Formula',
            'experimental' => 'Experimental Formula',
            'world_based' => 'World-Based Formula',
        ];
        
        // Get statuses for filter dropdown
        $statuses = [
            'pending' => 'Pending Confirmation',
            'confirmed' => 'Booking Confirmed',
            'in_progress' => 'Incubation In Progress',
            'candling' => 'Candling Phase',
            'lockdown' => 'Lockdown Phase',
            'hatching' => 'Hatching In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        
        return view('admin.incubation.index', compact('bookings', 'counts', 'serviceTypes', 'statuses'));
    }
    /**
     * Display the specified booking
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        
        return view('admin.incubation.view', compact('booking'));
    }
    
    /**
     * Show the form for editing the specified booking
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Get service types for dropdown
        $serviceTypes = [
            'jm_casabar' => 'JM Casabar Formula Incubation',
            'custom' => 'Custom Formula Incubation',
            'experimental' => 'Experimental Formula Incubation',
            'world_based' => 'World-Based Formula Incubation',
        ];
        
        // Get statuses for dropdown
        $statuses = [
            'pending' => 'Pending Confirmation',
            'confirmed' => 'Booking Confirmed',
            'in_progress' => 'Incubation In Progress',
            'candling' => 'Candling Phase',
            'lockdown' => 'Lockdown Phase',
            'hatching' => 'Hatching In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        
        return view('admin.bookings.edit', compact('booking', 'serviceTypes', 'statuses'));
    }
    
    /**
     * Update the specified booking
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|string',
            'egg_quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
        ]);
        
        // Update booking
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->address = $request->address;
        $booking->service_type = $request->service_type;
        $booking->egg_quantity = $request->egg_quantity;
        $booking->egg_source = $request->egg_source;
        $booking->start_date = $request->start_date;
        $booking->special_instructions = $request->special_instructions;
        
        // Update status if changed
        if ($booking->status != $request->status) {
            $booking->updateStatus($request->status, $request->status_notes);
        }
        
        // Update payment information if provided
        if ($request->has('deposit_paid')) {
            $booking->deposit_paid = $request->deposit_paid ? true : false;
            if ($request->deposit_paid && !$booking->deposit_paid_at) {
                $booking->deposit_paid_at = now();
            }
        }
        
        if ($request->has('balance_paid')) {
            $booking->balance_paid = $request->balance_paid ? true : false;
            if ($request->balance_paid && !$booking->balance_paid_at) {
                $booking->balance_paid_at = now();
            }
        }
        
        // Update candling results if provided
        if ($request->has('first_candling_fertile_count')) {
            $booking->first_candling_fertile_count = $request->first_candling_fertile_count;
        }
        
        if ($request->has('second_candling_fertile_count')) {
            $booking->second_candling_fertile_count = $request->second_candling_fertile_count;
        }
        
        if ($request->has('candling_notes')) {
            $booking->candling_notes = $request->candling_notes;
        }
        
        // Update hatching results if provided
        if ($request->has('hatched_count')) {
            $booking->hatched_count = $request->hatched_count;
            
            // Calculate hatch rate
            $baseCount = $booking->second_candling_fertile_count ?: $booking->egg_quantity;
            $booking->hatch_rate = $baseCount > 0 ? ($request->hatched_count / $baseCount) * 100 : 0;
        }
        
        if ($request->has('hatching_notes')) {
            $booking->hatching_notes = $request->hatching_notes;
        }
        
        // Save changes
        $booking->save();
        
        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Booking updated successfully');
    }
    
    /**
     * Update the status of a booking
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Validate request
        $request->validate([
            'status' => 'required|string',
            'status_notes' => 'nullable|string',
        ]);
        
        // Update status
        $booking->updateStatus($request->status, $request->status_notes);
        
        return redirect()->back()->with('success', 'Booking status updated successfully');
    }
    
    /**
     * Record candling results
     */
    public function recordCandling(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Validate request
        $request->validate([
            'fertile_count' => 'required|integer|min:0',
            'candling_notes' => 'nullable|string',
            'is_first_candling' => 'required|boolean',
        ]);
        
        // Record candling results
        $booking->recordCandlingResults(
            $request->fertile_count,
            $request->candling_notes,
            $request->is_first_candling
        );
        
        return redirect()->back()->with('success', 'Candling results recorded successfully');
    }
    
    /**
     * Record hatching results
     */
    public function recordHatching(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Validate request
        $request->validate([
            'hatched_count' => 'required|integer|min:0',
            'hatching_notes' => 'nullable|string',
        ]);
        
        // Record hatching results
        $booking->recordHatchingResults(
            $request->hatched_count,
            $request->hatching_notes
        );
        
        return redirect()->back()->with('success', 'Hatching results recorded successfully');
    }
    
    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        // Get filter parameters
        $status = $request->input('status');
        $serviceType = $request->input('service_type');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        // Start query
        $bookings = Booking::query();
        
        // Apply filters
        if ($status) {
            $bookings->where('status', $status);
        }
        
        if ($serviceType) {
            $bookings->where('service_type', $serviceType);
        }
        
        if ($dateFrom) {
            $bookings->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $bookings->whereDate('created_at', '<=', $dateTo);
        }
        
        // Get results
        $bookings = $bookings->orderBy('created_at', 'desc')->get();
        
        // Generate CSV
        $filename = 'incubation_bookings_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'Reference',
                'Customer',
                'Email',
                'Phone',
                'Service Type',
                'Eggs',
                'Start Date',
                'Status',
                'Total Price',
                'Deposit Paid',
                'Balance Paid',
                'Created At',
            ]);
            
            // Add data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->name,
                    $booking->email,
                    $booking->phone,
                    $booking->service_type_name,
                    $booking->egg_quantity,
                    $booking->start_date ? $booking->start_date->format('Y-m-d') : '',
                    $booking->status_name,
                    $booking->total_price,
                    $booking->deposit_paid ? 'Yes' : 'No',
                    $booking->balance_paid ? 'Yes' : 'No',
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
