@extends('layouts.public-site')

@section('title', 'Track order — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Pending',
            'preparing' => 'Preparing',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out for delivery',
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        $timelineStatuses = ['pending', 'preparing', 'processing', 'out_for_delivery', 'delivered'];

        $statusBadgeClass = function ($s) {
            return match ($s) {
                'delivered', 'completed' => 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-200',
                'out_for_delivery' => 'bg-violet-100 text-violet-900 ring-1 ring-violet-200',
                'processing' => 'bg-sky-100 text-sky-900 ring-1 ring-sky-200',
                'preparing' => 'bg-amber-100 text-amber-900 ring-1 ring-amber-200',
                'pending' => 'bg-amber-50 text-amber-950 ring-1 ring-amber-200',
                'cancelled' => 'bg-red-100 text-red-900 ring-1 ring-red-200',
                default => 'bg-stone-100 text-stone-800 ring-1 ring-stone-200',
            };
        };

        $timelineIndex = function ($orderStatus) use ($timelineStatuses) {
            $cur = $orderStatus === 'completed' ? 'delivered' : $orderStatus;
            $idx = $cur ? array_search($cur, $timelineStatuses, true) : false;
            return $idx;
        };
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-deep/90 mb-2">Orders</p>
            <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-forest">Track your orders</h2>
            <p class="text-sm text-stone-600 mt-2 max-w-2xl">
                Every successful purchase is listed below with products, totals, and live order status. You’ll get a short notice when any status changes.
            </p>
        </div>

        @if(($orders ?? collect())->isEmpty())
            <div class="bg-white rounded-2xl shadow-md border border-stone-200/80 p-8 text-center max-w-xl mx-auto">
                <p class="text-stone-700 mb-2">No purchase records found for your account yet.</p>
                <p class="text-sm text-stone-500">
                    Orders are matched to your account email (<span class="font-medium text-forest">{{ auth()->user()->email }}</span>).
                    If you checked out with a different email, those orders won’t appear here.
                </p>
                <a href="{{ route('home') }}" class="inline-flex mt-6 items-center justify-center gap-2 bg-forest text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-forest-dark transition-colors">
                    <i class="fas fa-shopping-bag"></i> Continue shopping
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($orders as $order)
                    @php
                        $items = $order->items ?? [];
                        if (!is_array($items)) {
                            $items = [];
                        }
                        $currentIndex = $timelineIndex($order->status ?? null);
                    @endphp

                    <article class="bg-white rounded-2xl shadow-md border border-stone-200/80 overflow-hidden" data-order-card="{{ $order->id }}">
                        <div class="p-6 sm:p-8 border-b border-stone-200/60 bg-cream/40">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-gold-deep/90 mb-1">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-stone-600">
                                        Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                                        <span class="text-stone-400">·</span>
                                        <span class="text-stone-500">Updated <span data-order-updated-at="{{ $order->id }}">{{ $order->updated_at->format('F j, Y, g:i a') }}</span></span>
                                    </p>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span
                                        data-order-status-badge="{{ $order->id }}"
                                        data-status="{{ $order->status }}"
                                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusBadgeClass($order->status) }}"
                                    >
                                        {{ $statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status ?? 'unknown')) }}
                                    </span>
                                    <span class="text-lg font-semibold text-forest">₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-1 space-y-4 text-sm">
                                <h3 class="font-semibold text-forest text-base">Delivery &amp; payment</h3>
                                <div class="space-y-2 text-stone-700">
                                    <p><span class="font-medium text-forest">Name:</span> {{ $order->name }}</p>
                                    <p><span class="font-medium text-forest">Email:</span> {{ $order->email }}</p>
                                    <p><span class="font-medium text-forest">Payment:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '—')) }}</p>
                                    @if($order->online_payment_method)
                                        <p><span class="font-medium text-forest">Online:</span> {{ ucfirst(str_replace('_', ' ', $order->online_payment_method)) }}</p>
                                    @endif
                                    <p class="pt-1"><span class="font-medium text-forest">Ship to:</span><br>{{ $order->address }}, {{ $order->city }}, {{ $order->zip }}</p>
                                </div>

                                <div class="rounded-xl border border-stone-200/80 bg-white/80 p-3 sm:p-4 shadow-sm">
                                    <h4 class="font-semibold text-forest text-sm mb-3">Progress</h4>
                                    @php
                                        $stepCount = count($timelineStatuses);
                                        // Track runs between first/last step centers (grid cols) — use 80% width, offset 10%.
                                        $trackFillPct = 0;
                                        if (($order->status ?? '') !== 'cancelled' && $currentIndex !== false && $stepCount > 1) {
                                            $trackFillPct = min(100, max(0, ($currentIndex / ($stepCount - 1)) * 100));
                                        }
                                    @endphp
                                    <div class="relative w-full select-none" aria-label="Order fulfillment progress">
                                        {{-- Baseline track (between step centers) --}}
                                        <div
                                            class="absolute left-[10%] right-[10%] top-[11px] h-[3px] rounded-full bg-stone-200/90 z-0"
                                            aria-hidden="true"
                                        ></div>
                                        {{-- Filled progress (same span as baseline) --}}
                                        <div
                                            class="absolute left-[10%] top-[11px] h-[3px] rounded-full bg-forest z-0 transition-[width] duration-300 ease-out"
                                            style="width: calc(80% * {{ $trackFillPct / 100 }})"
                                            aria-hidden="true"
                                        ></div>
                                        {{-- Steps: 5 equal columns so dots align with track endpoints --}}
                                        <div class="relative z-10 grid grid-cols-5 gap-0 items-start">
                                            @foreach($timelineStatuses as $idx => $statusKey)
                                                @php
                                                    $isDone = ($currentIndex !== false) && ($idx <= $currentIndex);
                                                    $isCurrent = ($currentIndex !== false) && ($idx === $currentIndex);
                                                @endphp
                                                <div class="flex flex-col items-center min-w-0 px-0.5">
                                                    <span
                                                        class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full border-2 transition-colors
                                                            {{ $isDone ? 'border-forest bg-forest text-white' : 'border-stone-300 bg-white text-stone-400' }}
                                                            {{ $isCurrent ? 'ring-2 ring-gold/50 ring-offset-2 ring-offset-cream' : '' }}"
                                                        title="{{ $statusLabels[$statusKey] }}"
                                                    >
                                                        @if($isDone)
                                                            <i class="fas fa-check text-[9px]"></i>
                                                        @else
                                                            <span class="text-[9px] font-semibold">{{ $idx + 1 }}</span>
                                                        @endif
                                                    </span>
                                                    <span class="mt-2 block w-full max-w-full text-center text-[9px] sm:text-[10px] leading-[1.15] hyphens-auto {{ $isDone ? 'text-forest font-medium' : 'text-stone-500' }} line-clamp-2 break-words">
                                                        {{ $statusLabels[$statusKey] }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <h3 class="font-serif text-lg font-semibold text-forest mb-4">Items in this order</h3>
                                <div class="overflow-x-auto rounded-xl border border-stone-200/80">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-cream/80 text-left text-stone-600">
                                                <th class="px-4 py-3 font-medium">Product</th>
                                                <th class="px-4 py-3 font-medium">Price</th>
                                                <th class="px-4 py-3 font-medium">Qty</th>
                                                <th class="px-4 py-3 font-medium text-right">Line total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-stone-200/80">
                                            @forelse($items as $line)
                                                <tr>
                                                    <td class="px-4 py-3 text-stone-800">{{ $line['name'] ?? 'Product' }}</td>
                                                    <td class="px-4 py-3">₱{{ number_format((float) ($line['price'] ?? 0), 2) }}</td>
                                                    <td class="px-4 py-3">{{ (int) ($line['quantity'] ?? 0) }}</td>
                                                    <td class="px-4 py-3 text-right font-medium text-forest">₱{{ number_format((float) ($line['total'] ?? (($line['price'] ?? 0) * ($line['quantity'] ?? 0))), 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-4 py-6 text-center text-stone-500">No line items were stored for this order.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <p class="mt-4 text-sm text-stone-500">
                                    <i class="fas fa-store text-gold-deep mr-1"></i> {{ $storeName }} — {{ $ownerAddress }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
@endsection

@if(isset($orders) && $orders->isNotEmpty())
@push('scripts')
<script>
(function () {
    var pollUrl = @json(route('checkout.track-status-json'));
    var statusLabels = @json($statusLabels);
    var lastMap = {};
    @foreach($orders as $o)
    lastMap[{{ $o->id }}] = { status: @json($o->status), updated_at: @json($o->updated_at->toIso8601String()) };
    @endforeach

    function badgeClassFor(s) {
        var m = {
            delivered: 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-200',
            completed: 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-200',
            out_for_delivery: 'bg-violet-100 text-violet-900 ring-1 ring-violet-200',
            processing: 'bg-sky-100 text-sky-900 ring-1 ring-sky-200',
            preparing: 'bg-amber-100 text-amber-900 ring-1 ring-amber-200',
            pending: 'bg-amber-50 text-amber-950 ring-1 ring-amber-200',
            cancelled: 'bg-red-100 text-red-900 ring-1 ring-red-200'
        };
        return m[s] || 'bg-stone-100 text-stone-800 ring-1 ring-stone-200';
    }

    function formatDate(iso) {
        if (!iso) return '';
        var d = new Date(iso);
        return d.toLocaleString(undefined, { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit' });
    }

    function poll() {
        fetch(pollUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.orders) return;
                data.orders.forEach(function (row) {
                    var id = row.id;
                    var prev = lastMap[id];
                    if (!prev) return;
                    if (row.status !== prev.status) {
                        lastMap[id].status = row.status;
                        lastMap[id].updated_at = row.updated_at;
                        var badge = document.querySelector('[data-order-status-badge="' + id + '"]');
                        if (badge) {
                            badge.setAttribute('data-status', row.status);
                            badge.textContent = row.status_label || statusLabels[row.status] || row.status;
                            badge.className = 'inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold ' + badgeClassFor(row.status);
                        }
                        var el = document.querySelector('[data-order-updated-at="' + id + '"]');
                        if (el && row.updated_at) el.textContent = formatDate(row.updated_at);
                        if (typeof window.showToast === 'function') {
                            window.showToast('Order #' + id + ' status: ' + (row.status_label || row.status), 'info');
                        }
                    } else if (row.updated_at && row.updated_at !== prev.updated_at) {
                        lastMap[id].updated_at = row.updated_at;
                        var el2 = document.querySelector('[data-order-updated-at="' + id + '"]');
                        if (el2) el2.textContent = formatDate(row.updated_at);
                    }
                });
            })
            .catch(function () {});
    }

    setInterval(poll, 20000);
})();
</script>
@endpush
@endif
