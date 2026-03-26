<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'jmcasabarsuccess@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('0147K!0147.'),
                'role' => 'super-admin',
            ]
        );
    }
}

