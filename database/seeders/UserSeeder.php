<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Parvez',
            'email' => 'admin@tarpor.com',
            'password' => Hash::make('Admin@123'),
            'avatar' => null, // Nullable, as per previous setup
            'email_verified_at' => now(),
        ]);
    }
}
