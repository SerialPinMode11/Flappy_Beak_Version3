<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use App\Models\DuckProducts;
use App\Models\WineProduct;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        $stripeKey = config('services.stripe.key');
        return view('customer.checkout', compact('cart', 'stripeKey'));
    }

    /**
     * Create a Stripe PaymentIntent for Card payment (amount in PHP centavos).
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = (float) $request->amount;
        $amountCentavos = (int) round($amount * 100); // Stripe PHP currency uses centavos

        if ($amountCentavos < 50) {
            return response()->json(['error' => 'Amount must be at least ₱0.50'], 422);
        }

        $stripeSecret = config('services.stripe.secret');
        if (empty($stripeSecret)) {
            return response()->json(['error' => 'Stripe is not configured'], 500);
        }

        try {
            $stripe = new StripeClient($stripeSecret);
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $amountCentavos,
                'currency' => 'php',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'order_total_php' => (string) round($amount, 2),
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
            ]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
            'online_payment_method' => 'nullable|required_if:payment_method,online|string|in:gcash,card',
            'reference_number' => 'nullable|required_if:online_payment_method,gcash|string|max:255',
            'payment_intent_id' => 'nullable|required_if:online_payment_method,card|string|max:255',
        ]);

        // Calculate total from cart and capture line items
        $total = 0;
        $cart = session()->get('cart', []);
        $items = [];
        foreach ($cart as $id => $details) {
            $lineTotal = $details['price'] * $details['quantity'];
            $total += $lineTotal;
            $items[] = [
                'product_id' => $id,
                'name' => $details['name'] ?? ($details['product_name'] ?? 'Product'),
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'total' => $lineTotal,
            ];
        }

        // If online + Card (Stripe): verify payment intent
        if ($request->payment_method === 'online' && $request->online_payment_method === 'card') {
            $stripeSecret = config('services.stripe.secret');
            if (empty($stripeSecret)) {
                return back()->withErrors(['payment' => 'Card payment is not configured.'])->withInput();
            }
            try {
                $stripe = new StripeClient($stripeSecret);
                $paymentIntent = $stripe->paymentIntents->retrieve($request->payment_intent_id);
                if ($paymentIntent->status !== 'succeeded') {
                    return back()->withErrors(['payment' => 'Payment was not completed. Please try again.'])->withInput();
                }
                $amountPaid = $paymentIntent->amount / 100;
                if (abs($amountPaid - $total) > 0.01) {
                    return back()->withErrors(['payment' => 'Payment amount does not match order total.'])->withInput();
                }
            } catch (ApiErrorException $e) {
                return back()->withErrors(['payment' => 'Invalid payment.'])->withInput();
            }
        }

        $status = ($request->payment_method === 'online' && $request->online_payment_method === 'card') ? 'completed' : 'pending';
        $referenceNumber = $request->online_payment_method === 'card' ? $request->payment_intent_id : $request->reference_number;

        $billingInfo = BillingInformation::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'payment_method' => $request->payment_method,
            'online_payment_method' => $request->online_payment_method,
            'reference_number' => $referenceNumber,
            'total_amount' => $total,
            'items' => $items,
            'status' => $status,
        ]);

        // Decrease stock for purchased products
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $qty = (int) ($item['quantity'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            // Try duck products first
            $duck = DuckProducts::find($productId);
            if ($duck) {
                $duck->decrement('product_stock', $qty);
                continue;
            }

            // Then try wine products
            $wine = WineProduct::find($productId);
            if ($wine) {
                $wine->decrement('product_stock', $qty);
            }
        }

        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Save billing data to session before Stripe redirect (for GCash etc).
     */
    public function saveBillingToSession(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
        ]);
        session([
            'checkout_billing' => [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
            ],
        ]);
        return response()->json(['ok' => true]);
    }

    /**
     * Return URL after Stripe redirect (e.g. GCash). Completes order from session.
     */
    public function returnFromStripe(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        if (!$paymentIntentId) {
            return redirect()->route('checkout')->withErrors(['payment' => 'Invalid return from payment.']);
        }
        $billing = session('checkout_billing');
        if (!$billing) {
            return redirect()->route('checkout')->withErrors(['payment' => 'Session expired. Please try again.']);
        }
        $stripeSecret = config('services.stripe.secret');
        if (empty($stripeSecret)) {
            return redirect()->route('checkout')->withErrors(['payment' => 'Payment is not configured.']);
        }
        try {
            $stripe = new StripeClient($stripeSecret);
            $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);
            if ($paymentIntent->status !== 'succeeded') {
                return redirect()->route('checkout')->withErrors(['payment' => 'Payment was not completed.']);
            }
        } catch (ApiErrorException $e) {
            return redirect()->route('checkout')->withErrors(['payment' => 'Invalid payment.']);
        }
        $total = 0;
        $cart = session()->get('cart', []);
        $items = [];
        foreach ($cart as $id => $details) {
            $lineTotal = $details['price'] * $details['quantity'];
            $total += $lineTotal;
            $items[] = [
                'product_id' => $id,
                'name' => $details['name'] ?? ($details['product_name'] ?? 'Product'),
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'total' => $lineTotal,
            ];
        }
        $amountPaid = $paymentIntent->amount / 100;
        if (abs($amountPaid - $total) > 0.01) {
            return redirect()->route('checkout')->withErrors(['payment' => 'Payment amount does not match order.']);
        }
        BillingInformation::create([
            'name' => $billing['name'],
            'email' => $billing['email'],
            'address' => $billing['address'],
            'city' => $billing['city'],
            'zip' => $billing['zip'],
            'payment_method' => 'online',
            'online_payment_method' => 'stripe',
            'reference_number' => $paymentIntentId,
            'total_amount' => $total,
            'items' => $items,
            'status' => 'completed',
        ]);
        // Decrease stock for purchased products (Stripe redirect flow)
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $qty = (int) ($item['quantity'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            $duck = DuckProducts::find($productId);
            if ($duck) {
                $duck->decrement('product_stock', $qty);
                continue;
            }

            $wine = WineProduct::find($productId);
            if ($wine) {
                $wine->decrement('product_stock', $qty);
            }
        }
        session()->forget('cart');
        session()->forget('checkout_billing');
        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('customer.success.success');
    }
}