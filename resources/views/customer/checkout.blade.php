@extends('layouts.default')

@section('title', 'Checkout - Flappy Beak')

@section('content')
    <main class="flex-grow container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8 text-neutral">Checkout</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="flex justify-between items-center mb-2">
                                <span>{{ $details['name'] }} (x{{ $details['quantity'] }})</span>
                                <span>₱{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    @endif
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between items-center font-semibold">
                            <span>Total:</span>
                            <span class="text-primary text-xl">₱{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Billing Information</h3>
                    <form id="billing-form" method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" id="address" name="address" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" id="city" name="city" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                                <input type="text" id="zip" name="zip" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                                @error('zip')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Payment Details</h3>
                <div id="payment-form">
                    <input type="hidden" id="payment_intent_id" name="payment_intent_id" form="billing-form" value="">
                    <div class="mb-4">
                        <label for="payment-method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select id="payment-method" name="payment_method" form="billing-form" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" required>
                            <option value="">Select payment method</option>
                            <option value="cash">Cash on Delivery</option>
                            <option value="online">Online Payment</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="online-payment-options" class="mb-4" style="display: none;">
                        <label for="online-payment-method" class="block text-sm font-medium text-gray-700 mb-1">Online Payment Method</label>
                        <select id="online-payment-method" name="online_payment_method" form="billing-form" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary">
                            <option value="">Select online payment method</option>
                            <option value="gcash">GCash</option>
                            <option value="card">Card (Stripe)</option>
                        </select>
                        @error('online_payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="reference-number-input" class="mb-4" style="display: none;">
                        <label for="reference-number" class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                        <img src="{{ asset('images/admin-gcash-portal.jpg') }}" alt="G-Cash Reference" class="w-48 h-auto rounded-md shadow-md mx-auto mb-3">
                        <input type="text" id="reference-number" name="reference_number" form="billing-form" class="w-full p-2 border rounded-md focus:ring-primary focus:border-primary" placeholder="Enter reference number">
                        @error('reference_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="stripe-payment-section" class="mb-4" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pay with Card</label>
                        <div id="payment-element" class="p-3 border rounded-md bg-gray-50 min-h-[120px]"></div>
                        <p id="stripe-error" class="text-red-500 text-sm mt-2 hidden"></p>
                    </div>
            
                    <div id="cash-on-delivery-message" class="mb-4" style="display: none;">
                        <p class="text-sm text-yellow-600">Please make sure the payment is ready.</p>
                        <button type="button" id="track-item-btn" class="mt-2 bg-secondary text-black px-4 py-2 rounded-md hover:bg-secondary-dark transition-colors">Track Item</button>
                    </div>
            
                    <button type="submit" form="billing-form" id="submit-btn" class="w-full bg-primary text-white px-6 py-3 rounded-full hover:bg-primary-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Pay Now
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment-method');
        const onlinePaymentOptions = document.getElementById('online-payment-options');
        const onlinePaymentMethodSelect = document.getElementById('online-payment-method');
        const referenceNumberInput = document.getElementById('reference-number-input');
        const stripePaymentSection = document.getElementById('stripe-payment-section');
        const cashOnDeliveryMessage = document.getElementById('cash-on-delivery-message');
        const submitBtn = document.getElementById('submit-btn');
        const trackItemBtn = document.getElementById('track-item-btn');
        const billingForm = document.getElementById('billing-form');
        const paymentIntentIdInput = document.getElementById('payment_intent_id');
        const stripeErrorEl = document.getElementById('stripe-error');

        const stripeKey = @json($stripeKey ?? '');
        const checkoutReturnUrl = @json(route('checkout.return'));
        const checkoutSaveBillingUrl = @json(route('checkout.save-billing'));
        const createPaymentIntentUrl = @json(route('checkout.create-payment-intent'));

        let stripe = null;
        let elements = null;
        let paymentElement = null;
        let clientSecret = null;

        paymentMethodSelect.addEventListener('change', function() {
            if (this.value === 'online') {
                onlinePaymentOptions.style.display = 'block';
                cashOnDeliveryMessage.style.display = 'none';
                submitBtn.textContent = 'Pay Now';
                paymentIntentIdInput.value = '';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                onlinePaymentMethodSelect.value = '';
            } else if (this.value === 'cash') {
                onlinePaymentOptions.style.display = 'none';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                cashOnDeliveryMessage.style.display = 'block';
                submitBtn.textContent = 'Confirm Order';
                paymentIntentIdInput.value = '';
            } else {
                onlinePaymentOptions.style.display = 'none';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                cashOnDeliveryMessage.style.display = 'none';
                submitBtn.textContent = 'Pay Now';
            }
        });

        onlinePaymentMethodSelect.addEventListener('change', function() {
            if (this.value === 'gcash') {
                referenceNumberInput.style.display = 'block';
                stripePaymentSection.style.display = 'none';
                paymentIntentIdInput.value = '';
            } else if (this.value === 'card') {
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'block';
                if (stripeKey && !clientSecret) initStripePayment();
            } else {
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                paymentIntentIdInput.value = '';
            }
        });

        function getOrderTotal() {
            let total = 0;
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    total += {{ $details['price'] * $details['quantity'] }};
                @endforeach
            @endif
            return total;
        }

        async function initStripePayment() {
            const total = getOrderTotal();
            if (total <= 0) return;
            submitBtn.disabled = true;
            stripeErrorEl.classList.add('hidden');
            try {
                const res = await fetch(createPaymentIntentUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
                    body: JSON.stringify({ amount: total })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Failed to create payment session');
                clientSecret = data.clientSecret;
                if (!stripe) stripe = Stripe(stripeKey);
                const appearance = { theme: 'stripe', variables: { colorPrimary: '#FF6B6B' } };
                if (!elements) elements = stripe.elements({ clientSecret, appearance });
                if (!paymentElement) {
                    paymentElement = elements.create('payment');
                    paymentElement.mount('#payment-element');
                } else {
                    elements.update({ clientSecret });
                }
            } catch (e) {
                stripeErrorEl.textContent = e.message || 'Could not load payment options.';
                stripeErrorEl.classList.remove('hidden');
            }
            submitBtn.disabled = false;
        }

        billingForm.addEventListener('submit', async function(e) {
            if (paymentMethodSelect.value !== 'online') return;
            if (onlinePaymentMethodSelect.value === 'gcash') return;
            if (onlinePaymentMethodSelect.value !== 'card') {
                e.preventDefault();
                return;
            }
            if (paymentIntentIdInput.value) return;
            e.preventDefault();
            if (!clientSecret || !stripe || !elements) {
                stripeErrorEl.textContent = 'Please wait for payment options to load.';
                stripeErrorEl.classList.remove('hidden');
                return;
            }
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const zip = document.getElementById('zip').value;
            if (!name || !email || !address || !city || !zip) {
                stripeErrorEl.textContent = 'Please fill in all billing details.';
                stripeErrorEl.classList.remove('hidden');
                return;
            }
            submitBtn.disabled = true;
            stripeErrorEl.classList.add('hidden');
            try {
                await fetch(checkoutSaveBillingUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
                    body: JSON.stringify({ name, email, address, city, zip })
                });
                const { error, paymentIntent } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: checkoutReturnUrl,
                        receipt_email: email,
                        payment_method_data: { billing_details: { name, address: { line1: address, city, postal_code: zip } } }
                    }
                });
                if (error) {
                    stripeErrorEl.textContent = error.message || 'Payment failed.';
                    stripeErrorEl.classList.remove('hidden');
                    submitBtn.disabled = false;
                    return;
                }
                if (paymentIntent && paymentIntent.status === 'succeeded') {
                    paymentIntentIdInput.value = paymentIntent.id;
                    billingForm.submit();
                }
            } catch (err) {
                stripeErrorEl.textContent = err.message || 'Something went wrong.';
                stripeErrorEl.classList.remove('hidden');
                submitBtn.disabled = false;
            }
        });

        trackItemBtn.addEventListener('click', function() {
            console.log('Tracking item...');
        });

        @if($errors->any())
        if (typeof showToast === 'function') {
            showToast({!! json_encode($errors->first()) !!}, 'error');
        }
        @endif
    });
</script>
@endpush