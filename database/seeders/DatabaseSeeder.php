<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default User
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@conq.ai',
            'password' => Hash::make('password'),
            'plan' => 'Pro',
            'credits' => 100,
        ]);
    }
}