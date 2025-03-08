<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('customer.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'payment_method' => 'required|string|in:cash,online',
            'online_payment_method' => 'nullable|required_if:payment_method,online|string|in:gcash,paymaya',
            'reference_number' => 'nullable|required_if:payment_method,online|string|max:255',
        ]);

        // Calculate total from cart
        $total = 0;
        $cart = session()->get('cart', []);
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Create billing information record
        $billingInfo = BillingInformation::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'payment_method' => $request->payment_method,
            'online_payment_method' => $request->online_payment_method,
            'reference_number' => $request->reference_number,
            'total_amount' => $total,
            'status' => 'pending'
        ]);

        // Clear cart after successful order
        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('customer.success.success');
    }
}