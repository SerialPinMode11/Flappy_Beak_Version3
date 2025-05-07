<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display the booking form
     */
    public function index()
    {
        // Get incubation service types for dropdown
        $incubationServices = [
            'jm_casabar' => 'JM Casabar Formula Incubation',
            'custom' => 'Custom Formula Incubation',
            'experimental' => 'Experimental Formula Incubation',
            'world_based' => 'World-Based Formula Incubation'
        ];

        return view('customer.addblade.bookincubation', compact('incubationServices'));
    }

    /**
     * Process the booking form submission
     */
    public function store(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'service_type' => 'required|string|in:jm_casabar,custom,experimental,world_based',
            'egg_quantity' => 'required|integer|min:1|max:300',
            'egg_source' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'special_instructions' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new booking
        $booking = new Booking();
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->address = $request->address;
        $booking->service_type = $request->service_type;
        $booking->egg_quantity = $request->egg_quantity;
        $booking->egg_source = $request->egg_source;
        $booking->start_date = $request->start_date;
        $booking->special_instructions = $request->special_instructions;
        $booking->status = 'pending';
        $booking->booking_reference = 'INC-' . time() . rand(1000, 9999);
        $booking->save();

        // Calculate price based on service type and quantity
        $pricePerBatch = [
            'jm_casabar' => 1500,
            'custom' => 2200,
            'experimental' => 2800,
            'world_based' => 2500
        ];

        $batchSize = 30;
        $batches = ceil($request->egg_quantity / $batchSize);
        $totalPrice = $pricePerBatch[$request->service_type] * $batches;

        // You could send email notification here
        // Mail::to($request->email)->send(new BookingConfirmation($booking, $totalPrice));

        // Flash success message and redirect
        return redirect()->route('booking.confirmation', ['reference' => $booking->booking_reference])
            ->with('success', 'Your incubation service has been booked successfully! Your reference number is: ' . $booking->booking_reference);
    }

    /**
     * Display booking confirmation
     */
    public function confirmation($reference)
    {
        $booking = Booking::where('booking_reference', $reference)->firstOrFail();

        // Calculate price based on service type and quantity
        $pricePerBatch = [
            'jm_casabar' => 1500,
            'custom' => 2200,
            'experimental' => 2800,
            'world_based' => 2500
        ];

        $batchSize = 30;
        $batches = ceil($booking->egg_quantity / $batchSize);
        $totalPrice = $pricePerBatch[$booking->service_type] * $batches;

        $serviceName = [
            'jm_casabar' => 'JM Casabar Formula Incubation',
            'custom' => 'Custom Formula Incubation',
            'experimental' => 'Experimental Formula Incubation',
            'world_based' => 'World-Based Formula Incubation'
        ];

        return view('customer.addblade.bookconfirm', compact('booking', 'totalPrice', 'serviceName'));
    }

    /**
     * Display booking status
     */
    public function status(Request $request)
    {
        $reference = $request->input('reference');

        if (!$reference) {
            return view('booking-status');
        }

        $booking = Booking::where('booking_reference', $reference)->first();

        if (!$booking) {
            return view('customer.addblade.bookstatus')->with('error', 'Booking not found. Please check your reference number.');
        }

        return view('customer.addblade.bookstatus', compact('booking'));
    }
}
