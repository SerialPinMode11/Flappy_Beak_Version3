<?php

namespace App\Http\Controllers;

use App\Models\FeedingHistory;
use App\Models\FeedInventory;
use App\Models\Admin;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private $validEmail = 'jmcasabarsuccess@gmail.com';
    private $validPassword = '0147K!0147.';


    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === $this->validEmail && $password === $this->validPassword) {
            // Successful login
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_email', $this->validEmail);
            $request->session()->put('admin_name', 'JM Casabar');
            return redirect()->route('admin.dashboard');
        } else {
            // Failed login
            return redirect()->route('login')->with('error', 'Invalid credentials. Please try again.');
        }
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->forget('admin_email');
        $request->session()->forget('admin_name');
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function editProfile(Request $request)
    {
        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();

        return view('admin.profile.edit', [
            'admin' => $admin,
            'adminEmail' => $email,
            'adminName' => $request->session()->get('admin_name', 'Admin'),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        // If admin record doesn't exist yet, create it (keeps your seeded/hardcoded flow working)
        if (!$admin) {
            $admin = new Admin();
            $admin->role = 'super-admin';
        }

        // Avoid duplicate email on update
        $existing = Admin::where('email', $validated['email'])
            ->when($admin->exists, fn ($q) => $q->where('id', '!=', $admin->id))
            ->exists();
        if ($existing) {
            return back()->with('error', 'Email is already used by another admin.')->withInput();
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();

        $request->session()->put('admin_email', $admin->email);
        $request->session()->put('admin_name', $admin->name);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function tologin()
    {
        return view('auth.adlogin');
    }
    public function toregister()
    {
        return view('auth.adregister');
    }
    public function toPersonal()
    {
        return view('admin.personal');
    }

    public function toHardware()
    {
        $feedingChart = $this->buildFeedingHistoryChart(30);
        $lastFeeding = FeedingHistory::query()->orderBy('fed_at', 'desc')->first();
        $todayKey = Carbon::today()->format('Y-m-d');
        $todayKg = 0.0;
        $todayRows = FeedingHistory::withoutGlobalScope('recent')
            ->whereDate('fed_at', $todayKey)
            ->get(['notes']);
        foreach ($todayRows as $row) {
            $todayKg += $this->parseKgFromNotes($row->notes);
        }

        $inventoryFeeds = FeedInventory::orderBy('feed_name')->get();
        $inventoryTotalKg = $this->sumInventoryQuantityAsKg($inventoryFeeds);
        $inventoryFeedCount = $inventoryFeeds->count();
        $inventoryInStockCount = $inventoryFeeds->where('status', 'In Stock')->count();
        $inventoryHealthPct = $inventoryFeedCount > 0
            ? (int) round(($inventoryInStockCount / $inventoryFeedCount) * 100)
            : 0;

        return view('admin.hardware', [
            'feedingChart' => $feedingChart,
            'lastFeeding' => $lastFeeding,
            'kgToday' => round($todayKg, 2),
            'totalKg30d' => round(array_sum($feedingChart['kg']), 2),
            'totalEvents30d' => array_sum($feedingChart['counts']),
            'inventoryFeeds' => $inventoryFeeds,
            'inventoryTotalKg' => round($inventoryTotalKg, 2),
            'inventoryHealthPct' => $inventoryHealthPct,
        ]);
    }

    public function toHardwareAnalytics()
    {
        return redirect()->route('admin.hardware_esp32');
    }



    public function toHardwareHistory()
    {
        $histories = FeedingHistory::paginate(15);
        $monthlyChart = $this->buildMonthlyFeedingChartSixMonths();
        $monthStats = $this->computeThisMonthFeedStats();

        return view('admin.hardware.history', compact('histories', 'monthlyChart', 'monthStats'));
    }

    public function feedNow(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'feed_inventory_id' => 'required|exists:feed_inventories,id',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $feed = FeedInventory::lockForUpdate()->findOrFail($validated['feed_inventory_id']);

            $amountKg = (float) $validated['amount'];
            $deduct = $this->kgDispensedToInventoryDeduction($feed, $amountKg);

            if ($deduct === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'This inventory item uses unit "'.$feed->unit.'". Add or edit the feed so the unit is kg or lbs, then dispensing will subtract stock correctly.',
                ], 422);
            }

            if ((float) $feed->quantity < $deduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock. Available: '.number_format((float) $feed->quantity, 2).' '.$feed->unit.'.',
                ], 422);
            }

            $feed->quantity = round((float) $feed->quantity - $deduct, 2);
            $feed->save();

            $fedBy = $request->session()->get('admin_name', 'Admin');

            $feeding = FeedingHistory::create([
                'fed_at' => now(),
                'fed_by' => $fedBy,
                'notes' => 'Amount: '.$amountKg.' kg, Type: '.$feed->feed_name.' ('.$feed->type.')',
                'is_manual' => false,
                'feed_inventory_id' => $feed->id,
            ]);

            $allFeeds = FeedInventory::orderBy('feed_name')->get();
            $inventoryTotalKg = round($this->sumInventoryQuantityAsKg($allFeeds), 2);
            $inventoryFeedCount = $allFeeds->count();
            $inventoryInStockCount = $allFeeds->where('status', 'In Stock')->count();
            $inventoryHealthPct = $inventoryFeedCount > 0
                ? (int) round(($inventoryInStockCount / $inventoryFeedCount) * 100)
                : 0;

            return response()->json([
                'success' => true,
                'message' => 'Feeding recorded successfully!',
                'data' => $feeding->fresh(['feedInventory']),
                'inventory_total_kg' => $inventoryTotalKg,
                'inventory_health_pct' => $inventoryHealthPct,
                'inventory_feed_count' => $inventoryFeedCount,
                'deducted_feed' => [
                    'id' => $feed->id,
                    'feed_name' => $feed->feed_name,
                    'type' => $feed->type,
                    'quantity_remaining' => (float) $feed->quantity,
                    'unit' => $feed->unit,
                    'status' => $feed->status,
                ],
            ]);
        });
    }
        // Store manual feeding record
    public function store(Request $request)
    {
        $validated = $request->validate([
        'fed_date' => 'required|date',
        'fed_time' => 'required',
        'notes' => 'nullable|string|max:500'
    ]);

    // Combine date and time
    $fedAt = $validated['fed_date'] . ' ' . $validated['fed_time'];

    $feeding = FeedingHistory::create([
        'fed_at' => $fedAt,
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
    ////////////
    ///
    //////////

    public function toHardwareInventory()
    {
        $feeds = FeedInventory::orderBy('feed_name')->get();
        
        // Calculate summary statistics
        $totalStock = $feeds->sum('quantity');
        $lowStockCount = $feeds->where('status', 'Low Stock')->count();
        $monthlyCost = $feeds->sum(function($feed) {
            return $feed->quantity * $feed->cost_per_unit;
        });
        $feedUsageTrend = $this->buildInventoryFeedUsageTrends(6);

        return view('admin.hardware.inventory', compact(
            'feeds',
            'totalStock',
            'lowStockCount',
            'monthlyCost',
            'feedUsageTrend'
        ));
    }

    public function toCreateFeed()
    {
        return view('admin.hardware.create-feed');
    }

    // Store new feed
    public function storeFeed(Request $request)
    {
        $validated = $request->validate([
            'feed_name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        FeedInventory::create($validated);

        return redirect()
            ->route('admin.hardwareInventory')
            ->with('success', 'Feed created successfully!');
    }

    // Update existing feed
    public function updateFeed(Request $request, $id)
    {
        $feed = FeedInventory::findOrFail($id);

        $validated = $request->validate([
            'feed_name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $feed->update($validated);

        return redirect()->back()->with('success', 'Feed updated successfully!');
    }

    // Delete feed (only if quantity is 0)
    public function destroyFeed($id)
    {
        $feed = FeedInventory::findOrFail($id);

        if ($feed->quantity > 0) {
            return redirect()->back()->with('error', 'Cannot delete feed with quantity greater than 0. Please reduce quantity to 0 first.');
        }

        $feed->delete();

        return redirect()->back()->with('success', 'Feed deleted successfully!');
    }

    public function toHardwareSetting()
    {
        return view('admin.hardware.settings');
    }

    /**
     * Parse kg from notes (e.g. "Amount: 0.5 kg, Type: Standard Feed").
     */
    private function parseKgFromNotes(?string $notes): float
    {
        if (! $notes) {
            return 0.0;
        }
        if (preg_match('/Amount:\s*([\d.]+)\s*kg/i', $notes, $m)) {
            return round((float) $m[1], 3);
        }

        return 0.0;
    }

    /**
     * Total stock for KPI: quantities normalized to kg where unit is known.
     *
     * @param  \Illuminate\Support\Collection<int, FeedInventory>  $feeds
     */
    private function sumInventoryQuantityAsKg($feeds): float
    {
        $sum = 0.0;
        foreach ($feeds as $feed) {
            $u = strtolower(trim((string) $feed->unit));
            $q = (float) $feed->quantity;
            if (in_array($u, ['kg', 'kgs', 'kilogram', 'kilograms'], true)) {
                $sum += $q;
            } elseif (in_array($u, ['lb', 'lbs', 'pound', 'pounds'], true)) {
                $sum += $q / 2.2046226218;
            } else {
                $sum += $q;
            }
        }

        return $sum;
    }

    /**
     * Convert a dispensed amount in kg into the same numeric unit as {@see FeedInventory::$quantity}.
     *
     * @return float|null  null if unit is not supported for auto-deduct
     */
    private function kgDispensedToInventoryDeduction(FeedInventory $feed, float $amountKg): ?float
    {
        $u = strtolower(trim((string) $feed->unit));
        if (in_array($u, ['kg', 'kgs', 'kilogram', 'kilograms'], true)) {
            return round($amountKg, 2);
        }
        if (in_array($u, ['lb', 'lbs', 'pound', 'pounds'], true)) {
            return round($amountKg * 2.2046226218, 2);
        }

        return null;
    }

    /**
     * Daily totals for the last N calendar days (including today).
     *
     * @return array{labels: array<int, string>, kg: array<int, float>, counts: array<int, int>, days: int}
     */
    private function buildFeedingHistoryChart(int $days = 30): array
    {
        $days = max(1, min(90, $days));
        $start = Carbon::today()->subDays($days - 1)->startOfDay();

        $rows = FeedingHistory::withoutGlobalScope('recent')
            ->where('fed_at', '>=', $start)
            ->orderBy('fed_at', 'asc')
            ->get(['fed_at', 'notes']);

        $byDay = [];
        foreach ($rows as $row) {
            $key = $row->fed_at->format('Y-m-d');
            if (! isset($byDay[$key])) {
                $byDay[$key] = ['kg' => 0.0, 'count' => 0];
            }
            $byDay[$key]['kg'] += $this->parseKgFromNotes($row->notes);
            $byDay[$key]['count']++;
        }

        $labels = [];
        $kg = [];
        $counts = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $key = $day->format('Y-m-d');
            $labels[] = $day->format('M j');
            $kg[] = round($byDay[$key]['kg'] ?? 0, 2);
            $counts[] = (int) ($byDay[$key]['count'] ?? 0);
        }

        return [
            'labels' => $labels,
            'kg' => $kg,
            'counts' => $counts,
            'days' => $days,
        ];
    }

    /**
     * Normalize feed type label from notes for stacked monthly chart.
     */
    private function parseFeedTypeBucket(?string $notes): string
    {
        if (! $notes || ! preg_match('/Type:\s*([^\n,]+)/i', $notes, $m)) {
            return 'Other';
        }
        $t = strtolower(trim($m[1]));
        if (str_contains($t, 'premium')) {
            return 'Premium Mix';
        }
        if (str_contains($t, 'growth')) {
            return 'Growth Formula';
        }
        if (str_contains($t, 'standard')) {
            return 'Standard Feed';
        }

        return 'Other';
    }

    /**
     * Extract feed label for usage trend from relation or notes.
     */
    private function parseFeedLabelForTrend(?string $notes, ?string $feedName): string
    {
        if ($feedName) {
            return trim($feedName);
        }

        if (! $notes || ! preg_match('/Type:\s*([^\n,]+)/i', $notes, $m)) {
            return 'Other';
        }

        $raw = trim($m[1]);
        // Notes now store "Type: {feed_name} ({type})"; keep feed name only.
        if (preg_match('/^(.*?)\s*\((.*?)\)\s*$/', $raw, $parts)) {
            $raw = trim($parts[1]);
        }

        return $raw !== '' ? $raw : 'Other';
    }

    /**
     * Monthly consumption (kg) grouped by feed label for last N months.
     *
     * @return array{labels: array<int, string>, series: array<int, array{name: string, data: array<int, float>>>}
     */
    private function buildInventoryFeedUsageTrends(int $months = 6): array
    {
        $months = max(1, min(12, $months));
        $monthKeys = [];
        $labels = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $m = Carbon::now()->startOfMonth()->subMonths($i);
            $monthKeys[] = $m->format('Y-m');
            $labels[] = $m->format('M Y');
        }
        $start = Carbon::parse($monthKeys[0] . '-01')->startOfMonth();

        $rows = FeedingHistory::withoutGlobalScope('recent')
            ->with(['feedInventory:id,feed_name'])
            ->where('fed_at', '>=', $start)
            ->orderBy('fed_at', 'asc')
            ->get(['fed_at', 'notes', 'feed_inventory_id']);

        $byFeedByMonth = [];
        foreach ($rows as $row) {
            $monthKey = $row->fed_at->format('Y-m');
            if (! in_array($monthKey, $monthKeys, true)) {
                continue;
            }

            $kg = $this->parseKgFromNotes($row->notes);
            if ($kg <= 0) {
                continue;
            }

            $feedLabel = $this->parseFeedLabelForTrend($row->notes, $row->feedInventory->feed_name ?? null);
            if (! isset($byFeedByMonth[$feedLabel])) {
                $byFeedByMonth[$feedLabel] = array_fill_keys($monthKeys, 0.0);
            }
            $byFeedByMonth[$feedLabel][$monthKey] += $kg;
        }

        if (empty($byFeedByMonth)) {
            return ['labels' => $labels, 'series' => []];
        }

        uasort($byFeedByMonth, function (array $a, array $b): int {
            return array_sum($b) <=> array_sum($a);
        });

        // Keep chart readable by showing top 5 feed labels + "Other".
        $maxSeries = 5;
        $byFeedByMonth = array_slice($byFeedByMonth, 0, $maxSeries, true);

        $series = [];
        foreach ($byFeedByMonth as $feedLabel => $monthMap) {
            $data = [];
            foreach ($monthKeys as $k) {
                $data[] = round((float) ($monthMap[$k] ?? 0), 2);
            }
            $series[] = ['name' => $feedLabel, 'data' => $data];
        }

        return ['labels' => $labels, 'series' => $series];
    }

    /**
     * Last 6 calendar months: kg per month split by feed type (from parsed notes).
     *
     * @return array{labels: array<int, string>, series: array<int, array{name: string, data: array<int, float>>}}
     */
    private function buildMonthlyFeedingChartSixMonths(): array
    {
        $months = 6;
        $monthKeys = [];
        $labels = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $m = Carbon::now()->startOfMonth()->subMonths($i);
            $monthKeys[] = $m->format('Y-m');
            $labels[] = $m->format('M Y');
        }
        $start = Carbon::parse($monthKeys[0].'-01')->startOfMonth();

        $rows = FeedingHistory::withoutGlobalScope('recent')
            ->where('fed_at', '>=', $start)
            ->orderBy('fed_at', 'asc')
            ->get(['fed_at', 'notes']);

        $typeKeys = ['Standard Feed', 'Premium Mix', 'Growth Formula', 'Other'];
        $byMonth = [];
        foreach ($monthKeys as $k) {
            $byMonth[$k] = array_fill_keys($typeKeys, 0.0);
        }

        foreach ($rows as $row) {
            $mk = $row->fed_at->format('Y-m');
            if (! isset($byMonth[$mk])) {
                continue;
            }
            $kg = $this->parseKgFromNotes($row->notes);
            $bucket = $this->parseFeedTypeBucket($row->notes);
            $byMonth[$mk][$bucket] += $kg;
        }

        $series = [];
        foreach ($typeKeys as $typeName) {
            $data = [];
            foreach ($monthKeys as $k) {
                $data[] = round($byMonth[$k][$typeName], 2);
            }
            $series[] = ['name' => $typeName, 'data' => $data];
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }

    /**
     * Summary numbers for the current month (from stored feeding rows).
     *
     * @return array{month_kg: float, compliance: float, cost_php: float, feeding_count: int}
     */
    private function computeThisMonthFeedStats(): array
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $rows = FeedingHistory::withoutGlobalScope('recent')
            ->whereBetween('fed_at', [$start, $end])
            ->get(['notes', 'fed_at']);

        $totalKg = 0.0;
        $count = 0;
        foreach ($rows as $row) {
            $totalKg += $this->parseKgFromNotes($row->notes);
            $count++;
        }

        $dayOfMonth = Carbon::now()->day;
        $targetPerDay = 2;
        $expectedSoFar = max(1, $dayOfMonth * $targetPerDay);
        $compliance = min(100, round(($count / $expectedSoFar) * 100, 1));

        $costPerKg = 27.2;

        return [
            'month_kg' => round($totalKg, 1),
            'compliance' => $compliance,
            'cost_php' => round($totalKg * $costPerKg, 2),
            'feeding_count' => $count,
        ];
    }
}