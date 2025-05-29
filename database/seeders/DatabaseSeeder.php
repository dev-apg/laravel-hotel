<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('hotels')->truncate();
        DB::table('rooms')->truncate();

        $this->call(HotelsSeeder::class);
        $this->call(RoomsSeeder::class);
    }
}
