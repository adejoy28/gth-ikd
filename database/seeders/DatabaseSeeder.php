<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'IKD',
            'phone' => '0123456789',
            'username' => 'admin',
            'email' => 'admin@admin.com',   
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    User::factory()->create([
        'firstname' => 'john',
        'lastname' => 'doe',
        'phone' => '0123456789',
        'username' => 'john',
        'email' => 'john@example.com',
        'password' => Hash::make('password'),
        'role' => 'user',
    ]);
    }
}
