<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $passwordHash = Hash::make('password');
        User::create([
            'name' => 'bob',
            'email' => 'bob@example.com',
            'password' => $passwordHash,
        ]);
    }
}
