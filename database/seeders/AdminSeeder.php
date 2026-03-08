<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@das.org.np',
                'password' => Hash::make('password'),
                'full_name' => 'Super Admin',
                'role' => 'admin',
                'status' => 'active',
                'permissions' => 'all',
            ]
        );

        Admin::updateOrCreate(
            ['username' => 'editor'],
            [
                'email' => 'editor@das.org.np',
                'password' => Hash::make('password'),
                'full_name' => 'Editor User',
                'role' => 'editor',
                'status' => 'active',
            ]
        );
    }
}
