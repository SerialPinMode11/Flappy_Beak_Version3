<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DuckProducts;
use App\Models\FeedInventory;
use App\Models\HogProduct;
use App\Models\WineProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnadminController extends Controller
{
    /**
     * Show the admin login form
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login request
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
            return redirect()->intended(route("admin.index"));
        }

        return back()->with('error', 'Invalid login credentials');
    }

    public function registerPost(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:admins",
            "password" => "required"
        ]);
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()){
            return redirect()->route('login')->with('success', 'User Registration Successful');
        }
        return redirect()->route('register')->with('error', 'User Registration Failed');
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        return view('admin.index');
    }

    /**
     * Log the admin out
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    //Next Page Function
    public function index(){
        $users = Admin::latest()->paginate(10);

        return view('admin.personal', compact('users'));
    }

    public function create(){
        return view('admin.personal.create');
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:admins",
            "password" => "required",
            "role" => "required"
        ]);

        // Create new admin user
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = $request->role;
        $admin->save();

        return redirect()->route('admin.personal')->with('success', 'Admin User added successfully!');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.personal')->with('success', 'Admin User deleted successfully!');
    }

    public function exportStockReport(): StreamedResponse
    {
        $filename = 'stock_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Table',
                'Record ID',
                'Product/Feed Name',
                'Category/Type',
                'Stock/Quantity',
                'Unit',
                'Price/Cost Per Unit',
                'Status',
                'Created At',
                'Updated At',
            ]);

            DuckProducts::query()->orderBy('id')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        'duckproducts',
                        $row->id,
                        $row->product_name,
                        $row->category ?? 'duck',
                        $row->product_stock,
                        'pcs',
                        $row->product_price,
                        '',
                        optional($row->created_at)->toDateTimeString(),
                        optional($row->updated_at)->toDateTimeString(),
                    ]);
                }
            });

            WineProduct::query()->orderBy('id')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        'wine_products',
                        $row->id,
                        $row->product_name,
                        'wine',
                        $row->product_stock,
                        'pcs',
                        $row->product_price,
                        '',
                        optional($row->created_at)->toDateTimeString(),
                        optional($row->updated_at)->toDateTimeString(),
                    ]);
                }
            });

            HogProduct::query()->orderBy('id')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        'hog_products',
                        $row->id,
                        $row->product_name,
                        'hog',
                        $row->product_stock,
                        'pcs',
                        $row->product_price,
                        '',
                        optional($row->created_at)->toDateTimeString(),
                        optional($row->updated_at)->toDateTimeString(),
                    ]);
                }
            });

            FeedInventory::query()->orderBy('id')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        'feed_inventories',
                        $row->id,
                        $row->feed_name,
                        $row->type,
                        $row->quantity,
                        $row->unit,
                        $row->cost_per_unit,
                        $row->status,
                        optional($row->created_at)->toDateTimeString(),
                        optional($row->updated_at)->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}

