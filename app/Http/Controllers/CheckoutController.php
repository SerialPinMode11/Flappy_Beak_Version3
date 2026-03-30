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
        $user = auth()->user();

        return view('customer.checkout', compact('cart', 'stripeKey', 'user'));
    }

    /**
     * All purchases for the logged-in customer (same email as checkout, case-insensitive).
     */
    public function trackItem()
    {
        $publicContent = \App\Models\PublicPageSetting::getContent();
        $ownerAddress = $publicContent['contact_address'] ?? 'Brgy. Maroyroy, Macatoc, Oriental Mindoro, Luzon Philippines';
        $storeName = $publicContent['store_name'] ?? 'JM Casabar Mini Farm';

        $orders = $this->billingQueryForCurrentUser()
            ->latest()
            ->get();

        return view('customer.track-item', compact('ownerAddress', 'storeName', 'orders'));
    }

    /**
     * JSON for polling: all order statuses for the current user (no ID in URL).
     */
    public function trackOrdersStatusJson()
    {
        $labels = [
            'pending' => 'Pending',
            'preparing' => 'Preparing',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out for delivery',
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $orders = $this->billingQueryForCurrentUser()
            ->get(['id', 'status', 'updated_at']);

        return response()->json([
            'orders' => $orders->map(function ($o) use ($labels) {
                $s = $o->status;
                return [
                    'id' => $o->id,
                    'status' => $s,
                    'status_label' => $labels[$s] ?? ucwords(str_replace('_', ' ', (string) $s)),
                    'updated_at' => $o->updated_at?->toIso8601String(),
                ];
            })->values(),
        ]);
    }

    /**
     * Match billing rows to the account email (case-insensitive), so orders still show if casing differs.
     */
    protected function billingQueryForCurrentUser()
    {
        $email = strtolower(trim((string) auth()->user()->email));

        return BillingInformation::query()
            ->whereRaw('LOWER(TRIM(email)) = ?', [$email]);
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
            'payment_method' => 'required|string|in:cash,online',
            'online_payment_method' => 'nullable|required_if:payment_method,online|string|in:gcash,card',
            'reference_number' => 'nullable|required_if:online_payment_method,gcash|string|max:255',
            'payment_intent_id' => 'nullable|required_if:online_payment_method,card|string|max:255',
        ]);

        $user = auth()->user();
        if (!$user->hasCompleteShippingProfile()) {
            return redirect()
                ->route('profile.edit')
                ->withErrors(['profile' => 'Please add your delivery address in your profile before completing checkout.']);
        }

        // Calculate total from cart and capture line items
        $total = 0;
        $cart = session()->get('cart', []);
        $items = [];
        foreach ($cart as $key => $details) {
            $lineTotal = $details['price'] * $details['quantity'];
            $total += $lineTotal;
            $items[] = [
                'product_key' => $key,
                'type' => $details['type'] ?? null,
                'product_id' => $details['id'] ?? null,
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
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'city' => $user->city,
            'zip' => $user->zip,
            'payment_method' => $request->payment_method,
            'online_payment_method' => $request->online_payment_method,
            'reference_number' => $referenceNumber,
            'total_amount' => $total,
            'items' => $items,
            'status' => $status,
        ]);

        // Decrease stock for purchased products
        foreach ($items as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            $type = $item['type'] ?? null;
            if ($type === 'wine') {
                $wine = WineProduct::find($productId);
                if ($wine) $wine->decrement('product_stock', $qty);
            } else {
                $duck = DuckProducts::find($productId);
                if ($duck) $duck->decrement('product_stock', $qty);
            }
        }

        session()->forget('cart');
        session(['last_billing_id' => $billingInfo->id]);

        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Save billing data to session before Stripe redirect (for GCash etc).
     */
    public function saveBillingToSession(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasCompleteShippingProfile()) {
            return response()->json([
                'error' => 'Please complete your delivery address in your profile before paying with card.',
            ], 422);
        }

        session([
            'checkout_billing' => [
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'city' => $user->city,
                'zip' => $user->zip,
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
        foreach ($cart as $key => $details) {
            $lineTotal = $details['price'] * $details['quantity'];
            $total += $lineTotal;
            $items[] = [
                'product_key' => $key,
                'type' => $details['type'] ?? null,
                'product_id' => $details['id'] ?? null,
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
        $billingInfo = BillingInformation::create([
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
            $productId = (int) ($item['product_id'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            $type = $item['type'] ?? null;
            if ($type === 'wine') {
                $wine = WineProduct::find($productId);
                if ($wine) $wine->decrement('product_stock', $qty);
            } else {
                $duck = DuckProducts::find($productId);
                if ($duck) $duck->decrement('product_stock', $qty);
            }
        }
        session()->forget('cart');
        session()->forget('checkout_billing');
        session(['last_billing_id' => $billingInfo->id]);
        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        $lastBillingId = session('last_billing_id');
        return view('customer.success.success', compact('lastBillingId'));
    }
}