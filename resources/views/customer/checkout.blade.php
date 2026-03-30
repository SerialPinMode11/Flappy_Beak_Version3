@extends('layouts.public-site')

@section('title', 'Checkout — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Payment</p>
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Checkout</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6 mb-8">
                    <h3 class="text-xl font-semibold text-forest mb-4">Order summary</h3>
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="flex justify-between items-center mb-2 text-stone-700">
                                <span>{{ $details['name'] }} (×{{ $details['quantity'] }})</span>
                                <span>₱{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    @endif
                    <div class="border-t border-stone-200/80 pt-2 mt-2">
                        <div class="flex justify-between items-center font-semibold text-forest">
                            <span>Total</span>
                            <span class="text-gold-deep text-xl">₱{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6">
                    <h3 class="text-xl font-semibold text-forest mb-2">Delivery details</h3>
                    <p class="text-sm text-stone-600 mb-4">Taken from your <a href="{{ route('profile.edit') }}" class="text-forest font-medium underline decoration-gold/50 underline-offset-2 hover:text-forest-dark">profile</a>. Update your address there anytime.</p>

                    @if(!$user->hasCompleteShippingProfile())
                        <div class="rounded-xl border border-amber-200 bg-amber-50/90 text-amber-950 text-sm px-4 py-3 mb-4">
                            <p class="font-medium mb-1">Delivery address required</p>
                            <p class="text-amber-900/90 mb-3">Add your street, city, and ZIP in your profile before you can place an order.</p>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 bg-forest text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-forest-dark transition-colors">
                                <i class="fas fa-user-edit"></i> Complete profile
                            </a>
                        </div>
                    @else
                        <div class="rounded-xl border border-stone-200/80 bg-cream/50 p-4 text-sm text-stone-700 space-y-2 mb-4">
                            <p><span class="font-medium text-forest">Name:</span> {{ $user->name }}</p>
                            <p><span class="font-medium text-forest">Email:</span> {{ $user->email }}</p>
                            @if($user->phone)
                                <p><span class="font-medium text-forest">Phone:</span> {{ $user->phone }}</p>
                            @endif
                            <p><span class="font-medium text-forest">Ship to:</span><br>{{ $user->address }}, {{ $user->city }}, {{ $user->zip }}</p>
                        </div>
                    @endif

                    <form id="billing-form" method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        {{-- Stripe JS reads these IDs; values come from the logged-in profile --}}
                        <input type="hidden" id="name" value="{{ $user->name }}">
                        <input type="hidden" id="email" value="{{ $user->email }}">
                        <input type="hidden" id="address" value="{{ $user->address ?? '' }}">
                        <input type="hidden" id="city" value="{{ $user->city ?? '' }}">
                        <input type="hidden" id="zip" value="{{ $user->zip ?? '' }}">
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-6">
                <h3 class="text-xl font-semibold text-forest mb-4">Payment details</h3>
                <div id="payment-form">
                    <input type="hidden" id="payment_intent_id" name="payment_intent_id" form="billing-form" value="">
                    <div class="mb-4">
                        <label for="payment-method" class="block text-sm font-medium text-stone-700 mb-1">Payment method</label>
                        <select id="payment-method" name="payment_method" form="billing-form" class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest" required>
                            <option value="">Select payment method</option>
                            <option value="cash">Cash on delivery</option>
                            <option value="online">Online payment</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="online-payment-options" class="mb-4" style="display: none;">
                        <label for="online-payment-method" class="block text-sm font-medium text-stone-700 mb-1">Online payment method</label>
                        <select id="online-payment-method" name="online_payment_method" form="billing-form" class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest">
                            <option value="">Select online payment method</option>
                            <option value="gcash">GCash</option>
                            <option value="card">Card (Stripe)</option>
                        </select>
                        @error('online_payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="reference-number-input" class="mb-4" style="display: none;">
                        <label for="reference-number" class="block text-sm font-medium text-stone-700 mb-1">Reference number</label>
                        <img src="{{ asset('images/admin-gcash-portal.jpg') }}" alt="G-Cash Reference" class="w-48 h-auto rounded-md shadow-md mx-auto mb-3">
                        <input type="text" id="reference-number" name="reference_number" form="billing-form" class="w-full p-2.5 border border-stone-200 rounded-lg focus:ring-2 focus:ring-gold/40 focus:border-forest" placeholder="Enter reference number">
                        @error('reference_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="stripe-payment-section" class="mb-4" style="display: none;">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Pay with card</label>
                        <div id="payment-element" class="p-3 border border-stone-200 rounded-lg bg-cream/80 min-h-[120px]"></div>
                        <p id="stripe-error" class="text-red-500 text-sm mt-2 hidden"></p>
                    </div>

                    <div id="cash-on-delivery-message" class="mb-4" style="display: none;">
                        <p class="text-sm text-amber-800">Please make sure the payment is ready.</p>
                        <button type="button" id="track-item-btn" class="mt-2 bg-gold text-forest px-4 py-2 rounded-lg hover:bg-gold-deep/90 transition-colors font-medium">Track order</button>
                    </div>

                    <button type="submit" form="billing-form" id="submit-btn" @if(!$user->hasCompleteShippingProfile()) disabled @endif class="w-full bg-forest text-white px-6 py-3 rounded-xl hover:bg-forest-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium shadow-sm">
                        Pay now
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
        const trackItemUrl = @json(route('checkout.track-item'));
        const profileComplete = @json($user->hasCompleteShippingProfile());

        let stripe = null;
        let elements = null;
        let paymentElement = null;
        let clientSecret = null;

        paymentMethodSelect.addEventListener('change', function() {
            if (this.value === 'online') {
                onlinePaymentOptions.style.display = 'block';
                cashOnDeliveryMessage.style.display = 'none';
                submitBtn.textContent = 'Pay now';
                paymentIntentIdInput.value = '';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                onlinePaymentMethodSelect.value = '';
            } else if (this.value === 'cash') {
                onlinePaymentOptions.style.display = 'none';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                cashOnDeliveryMessage.style.display = 'block';
                submitBtn.textContent = 'Confirm order';
                paymentIntentIdInput.value = '';
            } else {
                onlinePaymentOptions.style.display = 'none';
                referenceNumberInput.style.display = 'none';
                stripePaymentSection.style.display = 'none';
                cashOnDeliveryMessage.style.display = 'none';
                submitBtn.textContent = 'Pay now';
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
                const appearance = { theme: 'stripe', variables: { colorPrimary: '#1a3d2e' } };
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
            if (!profileComplete) {
                stripeErrorEl.textContent = 'Please complete your delivery address in your profile first.';
                stripeErrorEl.classList.remove('hidden');
                return;
            }
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
                stripeErrorEl.textContent = 'Please fill in your profile delivery address.';
                stripeErrorEl.classList.remove('hidden');
                return;
            }
            submitBtn.disabled = true;
            stripeErrorEl.classList.add('hidden');
            try {
                const saveRes = await fetch(checkoutSaveBillingUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
                    body: JSON.stringify({})
                });
                const saveData = await saveRes.json().catch(function () { return {}; });
                if (!saveRes.ok) {
                    stripeErrorEl.textContent = saveData.error || 'Could not prepare checkout.';
                    stripeErrorEl.classList.remove('hidden');
                    submitBtn.disabled = false;
                    return;
                }
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

        if (trackItemBtn) {
            trackItemBtn.addEventListener('click', function() {
                window.location.href = trackItemUrl;
            });
        }

        @if($errors->any())
        if (typeof showToast === 'function') {
            showToast({!! json_encode($errors->first()) !!}, 'error');
        }
        @endif
    });
</script>
@endpush
