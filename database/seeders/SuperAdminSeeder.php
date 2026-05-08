<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            // <managed-admin-seeder-records>
            [
                'name' => 'Super Admin',
                'email' => 'jmcasabarsuccess@gmail.com',
                'password' => '0147K!0147.',
                'role' => 'super-admin',
            ],
            // </managed-admin-seeder-records>
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                ]
            );
        }
    }
}

