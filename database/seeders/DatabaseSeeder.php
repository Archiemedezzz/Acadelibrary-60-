<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'librarian',
            'email' => 'librarian@acadelibrary.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
        ]);

        User::create([
            'name' => 'scholar',
            'email' => 'scholar@acadelibrary.com',
            'password' => Hash::make('password'),
            'role' => 'scholar',
        ]);
    }
}
