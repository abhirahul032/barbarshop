<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Seeder\AdminSeeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@system.com',
            'password' => Hash::make('LJ4PmG1MHKkHhm1x'), // <- test password
        ]);
    }
}
