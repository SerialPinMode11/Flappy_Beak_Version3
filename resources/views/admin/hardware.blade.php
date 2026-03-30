@extends('layouts.static')

@section('title', 'Hardware Control')

@push('styles')
<style>
    /* Manual feed status: readable in light + dark (body.dark) */
    .manual-feed-status-panel {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    body.dark .manual-feed-status-panel {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-text {
        color: #e2e8f0 !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-icon--info {
        color: #93c5fd !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-icon--warn {
        color: #fbbf24 !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-icon--ok {
        color: #34d399 !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-icon--err {
        color: #f87171 !important;
    }
    body.dark .manual-feed-status-panel .manual-feed-status-icon--spin {
        color: #a5b4fc !important;
    }

    /* Hardware dashboard — toggle switches & schedule list */
    .toggle-label {
        width: 44px;
        height: 24px;
        background-color: #e5e7eb;
    }

    .toggle-checkbox {
        width: 20px;
        height: 20px;
        top: 2px;
        left: 2px;
        transition: transform 0.2s ease-in-out;
    }

    .toggle-checkbox:checked {
        transform: translateX(20px);
    }

    .toggle-checkbox:checked + .toggle-label {
        background-color: #4f46e5;
    }

    .schedule-item:hover .delete-btn {
        display: flex;
    }

    .delete-btn {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Feeding Control</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor schedules, dispense feed, and review feeding history from the database.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div id="last-feeding-card" class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start border border-gray-100"@if($lastFeeding) data-fed-at="{{ $lastFeeding->fed_at->toIso8601String() }}"@endif>
                <div>
                    <p class="text-sm font-medium text-gray-500">Last Feeding</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1" id="last-feeding-time">
                        @if($lastFeeding)
                            {{ $lastFeeding->fed_at->format('D, g:i A') }}
                        @else
                            <span class="text-gray-400 text-lg font-normal">No records</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-400 mt-1"><i class="far fa-clock"></i> <span id="time-since-last">@if($lastFeeding){{ $lastFeeding->fed_at->diffForHumans() }}@else — @endif</span></p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="fas fa-utensils"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start border border-gray-100">
                <div>
                    <p class="text-sm font-medium text-gray-500">Feed Dispensed Today</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1" id="kg-today-display">{{ number_format($kgToday, 2) }} kg</p>
                    <p class="text-xs text-gray-500 mt-1">Parsed from logged amounts today</p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="fas fa-box"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start border border-gray-100">
                <div>
                    <p class="text-sm font-medium text-gray-500">Feed Inventory</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1" id="inventory-total-kg-display">{{ number_format($inventoryTotalKg, 2) }} kg</p>
                    <p class="text-xs text-gray-500 mt-1" id="inventory-health-caption">{{ $inventoryFeeds->count() }} item(s) · {{ $inventoryHealthPct }}% in full stock</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div id="inventory-health-bar" class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, $inventoryHealthPct) }}%"></div>
                    </div>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="fas fa-warehouse"></i></div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm flex justify-between items-start border border-gray-100">
                <div>
                    <p class="text-sm font-medium text-gray-500">Next Scheduled</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1" id="next-feeding-time"></p>
                    <p class="text-xs text-gray-400 mt-1"><i class="far fa-hourglass-half"></i> <span id="time-until-next"></span></p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="far fa-calendar-check"></i></div>
            </div>
        </div>

        <!-- Manual Feeding -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Manual Feeding Control</h3>
            <div class="flex flex-col sm:flex-row items-end gap-4 flex-wrap">
                <div class="w-full sm:w-auto">
                    <label for="feed-amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (kg)</label>
                    <div class="flex items-center">
                        <button type="button" id="decrease-amount" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold p-2.5 rounded-l-lg"><i class="fas fa-minus"></i></button>
                        <input type="number" id="feed-amount" class="w-20 text-center py-2 border-t border-b border-gray-300" value="0.5" step="0.1" min="0.1">
                        <button type="button" id="increase-amount" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold p-2.5 rounded-r-lg"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="w-full sm:flex-1 sm:min-w-[12rem]">
                    <label for="feed-type" class="block text-sm font-medium text-gray-700 mb-1">Feed (from inventory)</label>
                    <select id="feed-type" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" @if($inventoryFeeds->isEmpty()) disabled @endif>
                        @forelse($inventoryFeeds as $inv)
                            <option value="{{ $inv->id }}" @if((float) $inv->quantity <= 0) disabled @endif>
                                {{ $inv->feed_name }} — {{ number_format((float) $inv->quantity, 2) }} {{ $inv->unit }} ({{ $inv->type }})
                            </option>
                        @empty
                            <option value="">No feed in inventory — add stock first</option>
                        @endforelse
                    </select>
                    @if($inventoryFeeds->isEmpty())
                        <p class="text-xs text-amber-700 mt-1"><a href="{{ route('admin.hardwareInventory') }}" class="underline font-medium">Feed Inventory</a>: add feeds with quantity so dispensing can deduct stock.</p>
                    @endif
                </div>
                <div class="w-full sm:w-auto">
                    <button type="button" id="feed-now-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-2 px-6 rounded-lg shadow-md flex items-center justify-center" @if($inventoryFeeds->isEmpty() || $inventoryFeeds->every(fn ($f) => (float) $f->quantity <= 0)) disabled @endif>
                        <i class="fas fa-utensils mr-2"></i>Feed Now
                    </button>
                </div>
                <div id="feed-success" class="hidden w-full sm:w-auto mt-2 sm:mt-0 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">Feeding recorded successfully!</span>
                </div>
            </div>
            <div class="mt-4 p-3 rounded-md manual-feed-status-panel" id="manual-feed-status">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 manual-feed-status-icon--info mr-2"></i>
                    <p class="text-gray-700 text-sm manual-feed-status-text">Ready to dispense feed.</p>
                </div>
            </div>
        </div>

        <!-- Scheduled Feeding & History chart -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Scheduled Feeding</h3>
                    <button type="button" id="add-schedule-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Add Schedule
                    </button>
                </div>
                <ul id="schedule-list" class="space-y-2">
                    <li class="flex justify-between items-center py-3 border-b border-gray-100 schedule-item">
                        <div>
                            <h4 class="font-medium text-gray-900">Morning Feed</h4>
                            <p class="text-sm text-gray-500">Daily at 8:00 AM - 0.8 kg</p>
                        </div>
                        <div class="flex items-center">
                            <div class="relative mr-2">
                                <input type="checkbox" id="toggle1" class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer" checked>
                                <label for="toggle1" class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                            </div>
                            <button type="button" class="text-gray-400 hover:text-red-500 delete-btn"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </li>
                    <li class="flex justify-between items-center py-3 border-b border-gray-100 schedule-item">
                        <div>
                            <h4 class="font-medium text-gray-900">Afternoon Feed</h4>
                            <p class="text-sm text-gray-500">Daily at 1:00 PM - 0.5 kg</p>
                        </div>
                        <div class="flex items-center">
                            <div class="relative mr-2">
                                <input type="checkbox" id="toggle2" class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer" checked>
                                <label for="toggle2" class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                            </div>
                            <button type="button" class="text-gray-400 hover:text-red-500 delete-btn"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </li>
                    <li class="flex justify-between items-center py-3 schedule-item">
                        <div>
                            <h4 class="font-medium text-gray-900">Evening Feed</h4>
                            <p class="text-sm text-gray-500">Daily at 6:00 PM - 1.0 kg</p>
                        </div>
                        <div class="flex items-center">
                            <div class="relative mr-2">
                                <input type="checkbox" id="toggle3" class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer">
                                <label for="toggle3" class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label>
                            </div>
                            <button type="button" class="text-gray-400 hover:text-red-500 delete-btn"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex flex-col gap-2 mb-4">
                    <div class="flex flex-wrap justify-between items-start gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Feeding history (database)</h3>
                            <p class="text-sm text-gray-500 mt-1">Total <span class="font-medium text-gray-700">{{ $totalEvents30d }}</span> feedings · <span class="font-medium text-gray-700">{{ number_format($totalKg30d, 2) }} kg</span> in the last 30 days</p>
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="whitespace-nowrap">Show range</span>
                            <select id="history-period" class="border border-gray-300 rounded-md py-1.5 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="7" selected>Last 7 days</option>
                                <option value="14">Last 14 days</option>
                                <option value="30">Last 30 days</option>
                            </select>
                        </label>
                    </div>
                    <p class="text-xs text-gray-400">Daily totals use the <span class="font-mono">Amount: … kg</span> field stored in each feeding record.</p>
                </div>
                <div id="feedingHistoryChart" class="w-full min-h-[320px]" style="height: 340px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div id="schedule-modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-[100] hidden p-4">
    <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add Feeding Schedule</h3>
            <button type="button" id="close-modal" class="text-gray-500 hover:text-gray-700" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="schedule-form">
            <div class="mb-4">
                <label for="schedule-name" class="block text-sm font-medium text-gray-700 mb-1">Schedule Name</label>
                <input type="text" id="schedule-name" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Morning Feed" required>
            </div>
            <div class="mb-4">
                <label for="schedule-time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                <input type="time" id="schedule-time" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Days</label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Mon">Mon</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Tue">Tue</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Wed">Wed</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Thu">Thu</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Fri">Fri</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Sat">Sat</button>
                    <button type="button" class="day-btn px-3 py-1 border border-gray-300 rounded-md text-sm" data-day="Sun">Sun</button>
                </div>
            </div>
            <div class="mb-4">
                <label for="schedule-amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (kg)</label>
                <input type="number" id="schedule-amount" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="0.5" step="0.1" min="0.1" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancel-schedule" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script>
window.__feedingChartFull = @json($feedingChart);
document.addEventListener('DOMContentLoaded', function () {
    function updateTimeDisplays() {
        const card = document.getElementById('last-feeding-card');
        const iso = card && card.dataset ? card.dataset.fedAt : null;
        const lastEl = document.getElementById('last-feeding-time');
        const sinceEl = document.getElementById('time-since-last');
        if (iso && lastEl && sinceEl) {
            const m = moment(iso);
            lastEl.textContent = m.format('ddd, h:mm A');
            sinceEl.textContent = m.fromNow();
        }
        const now = moment();
        const nextEl = document.getElementById('next-feeding-time');
        const untilEl = document.getElementById('time-until-next');
        const nextFeeding = moment().add(3, 'hours').add(30, 'minutes');
        if (nextEl) nextEl.textContent = nextFeeding.format('ddd, h:mm A');
        if (untilEl) untilEl.textContent = 'in ' + moment.duration(nextFeeding.diff(now)).humanize();
    }
    updateTimeDisplays();
    setInterval(updateTimeDisplays, 60000);

    const decreaseBtn = document.getElementById('decrease-amount');
    const increaseBtn = document.getElementById('increase-amount');
    const feedAmountInput = document.getElementById('feed-amount');
    if (decreaseBtn && feedAmountInput) {
        decreaseBtn.addEventListener('click', function () {
            let value = parseFloat(feedAmountInput.value);
            if (value > 0.1) feedAmountInput.value = (value - 0.1).toFixed(1);
        });
    }
    if (increaseBtn && feedAmountInput) {
        increaseBtn.addEventListener('click', function () {
            let value = parseFloat(feedAmountInput.value);
            feedAmountInput.value = (value + 0.1).toFixed(1);
        });
    }

    const feedNowBtn = document.getElementById('feed-now-btn');
    if (feedNowBtn) {
        feedNowBtn.addEventListener('click', function () {
            const amount = document.getElementById('feed-amount').value;
            const feedSelect = document.getElementById('feed-type');
            const feedInventoryId = feedSelect ? feedSelect.value : '';
            const feedLabel = feedSelect && feedSelect.options[feedSelect.selectedIndex]
                ? feedSelect.options[feedSelect.selectedIndex].text
                : '';
            const statusDiv = document.getElementById('manual-feed-status');
            const btn = feedNowBtn;

            if (!feedInventoryId) {
                if (statusDiv) {
                    statusDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-exclamation-circle text-amber-600 manual-feed-status-icon--warn mr-2"></i><p class="text-gray-700 manual-feed-status-text text-sm">Choose a feed with available stock in inventory.</p></div>';
                }
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Recording...';

            if (statusDiv) {
                statusDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-spinner fa-spin text-indigo-600 manual-feed-status-icon--spin mr-2"></i><p class="text-gray-700 manual-feed-status-text text-sm">Dispensing ' + amount + ' kg — ' + feedLabel + '</p></div>';
            }

            fetch('{{ route("feed.now") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ amount: amount, feed_inventory_id: feedInventoryId })
            })
                .then(function (response) {
                    return response.json().then(function (json) {
                        return { ok: response.ok, data: json };
                    });
                })
                .then(function (res) {
                    var data = res.data;
                    if (!res.ok || !data.success) {
                        if (statusDiv) {
                            var msg = (data && data.message) ? data.message : 'Could not record feeding.';
                            statusDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-exclamation-circle text-red-500 manual-feed-status-icon--err mr-2"></i><p class="text-gray-700 manual-feed-status-text text-sm">' + msg + '</p></div>';
                        }
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-utensils mr-2"></i>Feed Now';
                        return;
                    }
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-check-circle text-emerald-600 manual-feed-status-icon--ok mr-2"></i><p class="text-gray-700 manual-feed-status-text text-sm">Successfully dispensed ' + amount + ' kg.</p></div>';
                        const card = document.getElementById('last-feeding-card');
                        var fedAtIso = (data.data && data.data.fed_at) ? data.data.fed_at : new Date().toISOString();
                        var m = moment(fedAtIso);
                        if (card) card.dataset.fedAt = fedAtIso;
                        const lastTime = document.getElementById('last-feeding-time');
                        const since = document.getElementById('time-since-last');
                        if (lastTime) lastTime.textContent = m.format('ddd, h:mm A');
                        if (since) since.textContent = m.fromNow();
                        var kgEl = document.getElementById('kg-today-display');
                        if (kgEl && amount) {
                            var cur = parseFloat(kgEl.textContent.replace(/[^\d.]/g, '')) || 0;
                            kgEl.textContent = (cur + parseFloat(amount)).toFixed(2) + ' kg';
                        }
                        const successDiv = document.getElementById('feed-success');
                        if (successDiv) {
                            successDiv.classList.remove('hidden');
                            setTimeout(function () { successDiv.classList.add('hidden'); }, 3000);
                        }
                        if (typeof data.inventory_total_kg !== 'undefined') {
                            var invKg = document.getElementById('inventory-total-kg-display');
                            if (invKg) invKg.textContent = parseFloat(data.inventory_total_kg).toFixed(2) + ' kg';
                            var cap = document.getElementById('inventory-health-caption');
                            if (cap && typeof data.inventory_health_pct !== 'undefined' && typeof data.inventory_feed_count !== 'undefined') {
                                cap.textContent = data.inventory_feed_count + ' item(s) · ' + data.inventory_health_pct + '% in full stock';
                            }
                            var bar = document.getElementById('inventory-health-bar');
                            if (bar && typeof data.inventory_health_pct !== 'undefined') {
                                bar.style.width = Math.min(100, data.inventory_health_pct) + '%';
                            }
                        }
                        if (data.deducted_feed && feedSelect) {
                            var opt = feedSelect.querySelector('option[value="' + data.deducted_feed.id + '"]');
                            if (opt) {
                                var df = data.deducted_feed;
                                opt.textContent = df.feed_name + ' — ' + parseFloat(df.quantity_remaining).toFixed(2) + ' ' + df.unit + ' (' + df.type + ')';
                                opt.disabled = parseFloat(df.quantity_remaining) <= 0;
                            }
                        }
                    }
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-utensils mr-2"></i>Feed Now';
                })
                .catch(function () {
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-exclamation-circle text-red-500 manual-feed-status-icon--err mr-2"></i><p class="text-gray-700 manual-feed-status-text text-sm">Failed to record feeding. Please try again.</p></div>';
                    }
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-utensils mr-2"></i>Feed Now';
                });
        });
    }

    const modal = document.getElementById('schedule-modal');
    const addScheduleBtn = document.getElementById('add-schedule-btn');
    if (addScheduleBtn && modal) {
        addScheduleBtn.addEventListener('click', function () {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    }
    function hideScheduleModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    const closeModalBtn = document.getElementById('close-modal');
    const cancelScheduleBtn = document.getElementById('cancel-schedule');
    if (closeModalBtn) closeModalBtn.addEventListener('click', hideScheduleModal);
    if (cancelScheduleBtn) cancelScheduleBtn.addEventListener('click', hideScheduleModal);

    document.querySelectorAll('.day-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.classList.toggle('bg-indigo-600');
            btn.classList.toggle('text-white');
        });
    });

    const scheduleForm = document.getElementById('schedule-form');
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('schedule-name').value;
            const time = moment(document.getElementById('schedule-time').value, 'HH:mm').format('h:mm A');
            const amount = document.getElementById('schedule-amount').value;
            const newScheduleItem = document.createElement('li');
            newScheduleItem.className = 'flex justify-between items-center py-3 border-b border-gray-100 schedule-item';
            newScheduleItem.innerHTML = '<div><h4 class="font-medium text-gray-900">' + name + '</h4><p class="text-sm text-gray-500">Daily at ' + time + ' - ' + amount + ' kg</p></div><div class="flex items-center"><div class="relative mr-2"><input type="checkbox" class="toggle-checkbox absolute rounded-full bg-white shadow-sm appearance-none cursor-pointer" checked/><label class="toggle-label block overflow-hidden rounded-full cursor-pointer"></label></div><button type="button" class="text-gray-400 hover:text-red-500 delete-btn"><i class="fas fa-trash-alt"></i></button></div>';
            const list = document.getElementById('schedule-list');
            if (list) list.appendChild(newScheduleItem);
            hideScheduleModal();
            scheduleForm.reset();
            document.querySelectorAll('.day-btn').forEach(function (b) {
                b.classList.remove('bg-indigo-600', 'text-white');
            });
        });
    }

    const scheduleList = document.getElementById('schedule-list');
    if (scheduleList) {
        scheduleList.addEventListener('click', function (e) {
            if (e.target.closest('.delete-btn')) {
                const item = e.target.closest('.schedule-item');
                if (item) item.remove();
            }
        });
    }

    if (typeof ApexCharts === 'undefined' || !window.__feedingChartFull) return;

    var full = window.__feedingChartFull;
    var labels = full.labels || [];
    var kgAll = full.kg || [];
    var countsAll = full.counts || [];

    function sliceLast(n) {
        n = Math.min(n, labels.length);
        var start = Math.max(0, labels.length - n);
        return {
            labels: labels.slice(start),
            kg: kgAll.slice(start),
            counts: countsAll.slice(start)
        };
    }

    function isDarkUi() {
        return document.body && document.body.classList.contains('dark');
    }

    function buildOptions(slice) {
        var dark = isDarkUi();
        var labelColor = dark ? '#94a3b8' : '#6b7280';
        var titleColor = dark ? '#cbd5e1' : '#374151';
        var gridColor = dark ? '#334155' : '#e5e7eb';
        return {
            theme: { mode: dark ? 'dark' : 'light' },
            series: [{
                name: 'Total feed (kg)',
                data: slice.kg
            }],
            chart: {
                type: 'area',
                height: 340,
                toolbar: { show: true },
                fontFamily: 'Inter, system-ui, sans-serif',
                zoom: { enabled: true },
                foreColor: dark ? '#cbd5e1' : '#374151'
            },
            colors: ['#4f46e5'],
            stroke: { curve: 'smooth', width: 2 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: dark ? 0.5 : 0.45,
                    opacityTo: dark ? 0.08 : 0.05,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: dark ? 4 : 0
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: slice.labels,
                title: { text: 'Day', style: { fontSize: '12px', color: titleColor } },
                labels: {
                    rotate: -35,
                    hideOverlappingLabels: true,
                    style: { colors: labelColor }
                }
            },
            yaxis: {
                title: {
                    text: 'Total kilograms (sum of logged amounts that day)',
                    style: { color: titleColor }
                },
                min: 0,
                labels: {
                    formatter: function (v) { return v.toFixed(2); },
                    style: { colors: labelColor }
                }
            },
            tooltip: {
                theme: dark ? 'dark' : 'light',
                y: {
                    formatter: function (val, opts) {
                        var i = opts.dataPointIndex;
                        var c = slice.counts[i] != null ? slice.counts[i] : 0;
                        return (val != null ? parseFloat(val).toFixed(2) : '0') + ' kg · ' + c + ' feeding(s)';
                    }
                }
            },
            markers: { size: 3, hover: { size: 7 } },
            legend: {
                show: true,
                position: 'top',
                labels: { colors: [titleColor] }
            }
        };
    }

    var periodSelect = document.getElementById('history-period');
    var currentDays = periodSelect ? parseInt(periodSelect.value, 10) || 7 : 7;
    var slice = sliceLast(currentDays);
    var opts = buildOptions(slice);

    var el1 = document.querySelector('#feedingHistoryChart');
    var feedingChart = null;
    if (el1) {
        feedingChart = new ApexCharts(el1, opts);
        feedingChart.render();
    }

    if (periodSelect && el1) {
        periodSelect.addEventListener('change', function () {
            var n = parseInt(periodSelect.value, 10) || 7;
            slice = sliceLast(n);
            if (feedingChart) feedingChart.destroy();
            feedingChart = new ApexCharts(el1, buildOptions(slice));
            feedingChart.render();
        });
    }
});
</script>
@endpush
