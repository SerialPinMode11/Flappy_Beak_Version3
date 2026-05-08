<?php

namespace App\Http\Controllers;

use App\Models\FeedingHistory;
use App\Models\FeedInventory;
use App\Models\Admin;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private $validEmail = 'jmcasabarsuccess@gmail.com';
    private $validPassword = '0147K!0147.';


    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === $this->validEmail && $password === $this->validPassword) {
            $admin = Admin::where('email', $this->validEmail)->first();

            // If 2FA is enabled, require TOTP challenge before login completes.
            if ($admin && !empty($admin->two_factor_secret) && !empty($admin->two_factor_enabled_at)) {
                $request->session()->put('admin_2fa_pending_email', $this->validEmail);
                return redirect()->route('admin.2fa.challenge');
            }

            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_email', $this->validEmail);
            $request->session()->put('admin_name', 'JM Casabar');
            $request->session()->put('admin_photo_url', $this->resolveAdminPhotoUrl($admin));
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
        $request->session()->forget('admin_photo_url');
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function editProfile(Request $request)
    {
        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();
        $resolvedPhotoUrl = $this->resolveAdminPhotoUrl($admin);

        // Keep header avatar/name in sync with latest profile values.
        $request->session()->put('admin_photo_url', $resolvedPhotoUrl);
        if ($admin && !empty($admin->name)) {
            $request->session()->put('admin_name', $admin->name);
        }

        $tab = $request->query('tab', 'profile');
        $tab = in_array($tab, ['profile', 'security'], true) ? $tab : 'profile';
        $isTwoFactorEnabled = (bool) ($admin && !empty($admin->two_factor_secret) && !empty($admin->two_factor_enabled_at));
        $hasPendingTwoFactor = (bool) ($admin && !empty($admin->two_factor_secret) && empty($admin->two_factor_enabled_at));

        $qrCodeUrl = null;
        if ($admin && !empty($admin->two_factor_secret) && ($isTwoFactorEnabled || $hasPendingTwoFactor)) {
            $otpauth = $this->buildOtpAuthUrl($admin->email, $admin->two_factor_secret);
            $qrCodeUrl = 'https://quickchart.io/qr?size=240&text=' . urlencode($otpauth);
        }

        return view('admin.profile.edit', [
            'admin' => $admin,
            'adminEmail' => $email,
            'adminName' => $request->session()->get('admin_name', 'Admin'),
            'adminPhotoUrl' => $resolvedPhotoUrl,
            'activeTab' => $tab,
            'isTwoFactorEnabled' => $isTwoFactorEnabled,
            'hasPendingTwoFactor' => $hasPendingTwoFactor,
            'qrCodeUrl' => $qrCodeUrl,
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
            'profile_photo' => 'nullable|image|max:2048',
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
        if ($request->hasFile('profile_photo')) {
            if (!empty($admin->profile_photo_path) && Storage::disk('public')->exists($admin->profile_photo_path)) {
                Storage::disk('public')->delete($admin->profile_photo_path);
            }
            $admin->profile_photo_path = $request->file('profile_photo')->store('admin-photos', 'public');
        }
        $admin->save();

        $request->session()->put('admin_email', $admin->email);
        $request->session()->put('admin_name', $admin->name);
        $request->session()->put('admin_photo_url', $this->resolveAdminPhotoUrl($admin));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function enableTwoFactor(Request $request): RedirectResponse
    {
        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return back()->with('error', 'Admin profile not found.');
        }

        $admin->two_factor_secret = $this->generateBase32Secret(32);
        $admin->two_factor_enabled_at = null;
        $admin->save();

        return redirect()->route('admin.profile.edit', ['tab' => 'security'])
            ->with('success', 'Two-factor setup started. Scan the QR code, then enter the 6-digit code to confirm.');
    }

    public function verifyTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|min:6|max:8',
        ]);

        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();
        if (!$admin || empty($admin->two_factor_secret)) {
            return back()->with('error', 'Two-factor setup is not initialized.');
        }

        $code = preg_replace('/\s+/', '', (string) $request->input('code'));
        if (!$this->verifyTotpCode($admin->two_factor_secret, $code)) {
            return redirect()->route('admin.profile.edit', ['tab' => 'security'])
                ->with('error', 'Invalid authenticator code. Please try again.');
        }

        $admin->two_factor_enabled_at = now();
        $admin->save();

        return redirect()->route('admin.profile.edit', ['tab' => 'security'])
            ->with('success', 'Two-factor authentication enabled successfully.');
    }

    public function disableTwoFactor(Request $request): RedirectResponse
    {
        $email = $request->session()->get('admin_email', $this->validEmail);
        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return back()->with('error', 'Admin profile not found.');
        }

        $admin->two_factor_secret = null;
        $admin->two_factor_enabled_at = null;
        $admin->save();

        return redirect()->route('admin.profile.edit', ['tab' => 'security'])
            ->with('success', 'Two-factor authentication disabled.');
    }

    public function twoFactorChallenge(Request $request)
    {
        if ($request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        if (!$request->session()->has('admin_2fa_pending_email')) {
            return redirect()->route('admin.login')->with('error', 'Your two-factor session expired. Please log in again.');
        }

        return view('auth.admin-2fa');
    }

    public function verifyTwoFactorChallenge(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|min:6|max:8',
        ]);

        $email = $request->session()->get('admin_2fa_pending_email');
        if (!$email) {
            return redirect()->route('admin.login')->with('error', 'Your two-factor session expired. Please log in again.');
        }

        $admin = Admin::where('email', $email)->first();
        if (!$admin || empty($admin->two_factor_secret) || empty($admin->two_factor_enabled_at)) {
            return redirect()->route('admin.login')->with('error', 'Two-factor is not enabled for this account.');
        }

        $code = preg_replace('/\s+/', '', (string) $request->input('code'));
        if (!$this->verifyTotpCode($admin->two_factor_secret, $code)) {
            return back()->with('error', 'Invalid authenticator code. Please try again.');
        }

        $request->session()->forget('admin_2fa_pending_email');
        $request->session()->put('admin_logged_in', true);
        $request->session()->put('admin_email', $admin->email);
        $request->session()->put('admin_name', $admin->name ?: 'Admin');
        $request->session()->put('admin_photo_url', $this->resolveAdminPhotoUrl($admin));

        return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
    }

    private function resolveAdminPhotoUrl(?Admin $admin): string
    {
        if ($admin && !empty($admin->profile_photo_path) && Storage::disk('public')->exists($admin->profile_photo_path)) {
            return asset('storage/' . $admin->profile_photo_path);
        }

        return 'https://randomuser.me/api/portraits/men/1.jpg';
    }

    private function buildOtpAuthUrl(string $email, string $secret): string
    {
        $issuer = 'Store Duck Admin';
        $label = rawurlencode($issuer . ':' . $email);
        return "otpauth://totp/{$label}?secret={$secret}&issuer=" . rawurlencode($issuer) . '&digits=6&period=30';
    }

    private function generateBase32Secret(int $length = 32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        return $secret;
    }

    private function verifyTotpCode(string $base32Secret, string $code, int $window = 1): bool
    {
        if (!preg_match('/^\d{6}$/', $code)) {
            return false;
        }

        $timeSlice = (int) floor(time() / 30);
        for ($offset = -$window; $offset <= $window; $offset++) {
            if (hash_equals($this->totpCode($base32Secret, $timeSlice + $offset), $code)) {
                return true;
            }
        }
        return false;
    }

    private function totpCode(string $base32Secret, int $timeSlice): string
    {
        $secretKey = $this->base32Decode($base32Secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hm = hash_hmac('sha1', $time, $secretKey, true);
        $offset = ord(substr($hm, -1)) & 0x0F;
        $value = (
            ((ord($hm[$offset]) & 0x7F) << 24) |
            ((ord($hm[$offset + 1]) & 0xFF) << 16) |
            ((ord($hm[$offset + 2]) & 0xFF) << 8) |
            (ord($hm[$offset + 3]) & 0xFF)
        ) % 1000000;

        return str_pad((string) $value, 6, '0', STR_PAD_LEFT);
    }

    private function base32Decode(string $secret): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper(preg_replace('/[^A-Z2-7]/', '', $secret) ?? '');
        $bits = '';

        foreach (str_split($secret) as $char) {
            $pos = strpos($alphabet, $char);
            if ($pos === false) {
                continue;
            }
            $bits .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }

        $decoded = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $decoded .= chr(bindec($byte));
            }
        }

        return $decoded;
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

        // Keep legend readable; top feeds first (highest consumed).
        $maxSeries = 6;
        $top = array_slice($byFeedByMonth, 0, $maxSeries, true);
        $rest = array_slice($byFeedByMonth, $maxSeries, null, true);
        if (! empty($rest)) {
            $other = array_fill_keys($monthKeys, 0.0);
            foreach ($rest as $monthMap) {
                foreach ($monthKeys as $k) {
                    $other[$k] += (float) ($monthMap[$k] ?? 0);
                }
            }
            $top['Other Feeds'] = $other;
        }

        $series = [];
        foreach ($top as $feedName => $monthMap) {
            $data = [];
            foreach ($monthKeys as $k) {
                $data[] = round((float) ($monthMap[$k] ?? 0), 2);
            }
            $series[] = ['name' => $feedName, 'data' => $data];
        }

        return ['labels' => $labels, 'series' => $series];
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