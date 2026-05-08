<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DuckProducts;
use App\Models\FeedInventory;
use App\Models\HogProduct;
use App\Models\WineProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
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

        DB::transaction(function () use ($request) {
            // Create new admin user
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->save();

            // Keep seeder credentials in sync with admin creation.
            $this->syncAdminSeederUpsert(
                $request->name,
                $request->email,
                $request->password,
                $request->role
            );
        });

        return redirect()->route('admin.personal')->with('success', 'Admin User added successfully!');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $admin = Admin::findOrFail($id);
            $email = $admin->email;
            $admin->delete();

            // Revoke credentials from seeder so reseeding won't recreate access.
            $this->syncAdminSeederRemoveByEmail($email);
        });

        return redirect()->route('admin.personal')->with('success', 'Admin User deleted successfully!');
    }

    private function syncAdminSeederUpsert(string $name, string $email, string $password, string $role): void
    {
        $path = database_path('seeders/SuperAdminSeeder.php');

        if (!file_exists($path)) {
            throw new RuntimeException('SuperAdminSeeder.php was not found.');
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new RuntimeException('Unable to read SuperAdminSeeder.php.');
        }

        $pattern = '/\/\/ <managed-admin-seeder-records>(.*?)\/\/ <\/managed-admin-seeder-records>/s';
        if (!preg_match($pattern, $contents, $matches)) {
            throw new RuntimeException('Seeder record markers were not found in SuperAdminSeeder.php.');
        }

        $block = $matches[1];
        $entryPattern = '/\[\s*\'name\'\s*=>\s*\'([^\']*)\',\s*\'email\'\s*=>\s*\'([^\']*)\',\s*\'password\'\s*=>\s*\'([^\']*)\',\s*\'role\'\s*=>\s*\'([^\']*)\',\s*\],?/s';
        preg_match_all($entryPattern, $block, $entries, PREG_SET_ORDER);

        $records = [];
        foreach ($entries as $entry) {
            $records[] = [
                'name' => $entry[1],
                'email' => $entry[2],
                'password' => $entry[3],
                'role' => $entry[4],
            ];
        }

        $updated = false;
        foreach ($records as &$record) {
            if (strcasecmp($record['email'], $email) === 0) {
                $record['name'] = $name;
                $record['password'] = $password;
                $record['role'] = $role;
                $updated = true;
                break;
            }
        }
        unset($record);

        if (!$updated) {
            $records[] = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
            ];
        }

        $newBlock = "\n";
        foreach ($records as $record) {
            $newBlock .= "            [\n";
            $newBlock .= "                'name' => " . var_export($record['name'], true) . ",\n";
            $newBlock .= "                'email' => " . var_export($record['email'], true) . ",\n";
            $newBlock .= "                'password' => " . var_export($record['password'], true) . ",\n";
            $newBlock .= "                'role' => " . var_export($record['role'], true) . ",\n";
            $newBlock .= "            ],\n";
        }

        $replacement = "// <managed-admin-seeder-records>" . $newBlock . "            // </managed-admin-seeder-records>";
        $updatedContents = preg_replace($pattern, $replacement, $contents, 1);

        if ($updatedContents === null || file_put_contents($path, $updatedContents) === false) {
            throw new RuntimeException('Unable to update SuperAdminSeeder.php.');
        }
    }

    private function syncAdminSeederRemoveByEmail(string $email): void
    {
        $path = database_path('seeders/SuperAdminSeeder.php');

        if (!file_exists($path)) {
            throw new RuntimeException('SuperAdminSeeder.php was not found.');
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new RuntimeException('Unable to read SuperAdminSeeder.php.');
        }

        $pattern = '/\/\/ <managed-admin-seeder-records>(.*?)\/\/ <\/managed-admin-seeder-records>/s';
        if (!preg_match($pattern, $contents, $matches)) {
            throw new RuntimeException('Seeder record markers were not found in SuperAdminSeeder.php.');
        }

        $block = $matches[1];
        $entryPattern = '/\[\s*\'name\'\s*=>\s*\'([^\']*)\',\s*\'email\'\s*=>\s*\'([^\']*)\',\s*\'password\'\s*=>\s*\'([^\']*)\',\s*\'role\'\s*=>\s*\'([^\']*)\',\s*\],?/s';
        preg_match_all($entryPattern, $block, $entries, PREG_SET_ORDER);

        $records = [];
        foreach ($entries as $entry) {
            if (strcasecmp($entry[2], $email) === 0) {
                continue;
            }

            $records[] = [
                'name' => $entry[1],
                'email' => $entry[2],
                'password' => $entry[3],
                'role' => $entry[4],
            ];
        }

        $newBlock = "\n";
        foreach ($records as $record) {
            $newBlock .= "            [\n";
            $newBlock .= "                'name' => " . var_export($record['name'], true) . ",\n";
            $newBlock .= "                'email' => " . var_export($record['email'], true) . ",\n";
            $newBlock .= "                'password' => " . var_export($record['password'], true) . ",\n";
            $newBlock .= "                'role' => " . var_export($record['role'], true) . ",\n";
            $newBlock .= "            ],\n";
        }

        $replacement = "// <managed-admin-seeder-records>" . $newBlock . "            // </managed-admin-seeder-records>";
        $updatedContents = preg_replace($pattern, $replacement, $contents, 1);

        if ($updatedContents === null || file_put_contents($path, $updatedContents) === false) {
            throw new RuntimeException('Unable to update SuperAdminSeeder.php.');
        }
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

