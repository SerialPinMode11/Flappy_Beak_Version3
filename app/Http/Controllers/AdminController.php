<?php

namespace App\Http\Controllers;

use App\Models\FeedingHistory;
use App\Models\FeedInventory;
use App\Models\Admin;

use Illuminate\Http\Request;

use Carbon\Carbon;
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
        return redirect()->route('admin.hardwareHistory');
    }
    
    public function toHardwareAnalytics()
    {
        return view('admin.hardware.analyticTobe');
    }



    public function toHardwareHistory()
    {
        $histories = FeedingHistory::paginate(15);
        return view('admin.hardware.history', compact('histories'));
        
    }

    public function feedNow(Request $request)
    {
        $feeding = FeedingHistory::create([
            'fed_at' => now(),
            'fed_by' => 'JM Casabar', // If you have auth
            'notes' => "Amount: " . ($request->amount ?? 'N/A') . " kg, Type: " . ($request->feed_type ?? 'N/A'),
            'is_manual' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feeding recorded successfully!',
            'data' => $feeding
        ]);
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
        return view('admin.hardware.inventory', compact('feeds', 'totalStock', 'lowStockCount', 'monthlyCost'));
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

        return redirect()->back()->with('success', 'Feed added successfully!');
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
}