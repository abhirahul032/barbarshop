<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@system.com',
            'password' => Hash::make('LJ4PmG1MHKkHhm1x'), // <- test password
        ]);
    }
}
