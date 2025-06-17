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
        DB::table('users')->truncate();
        DB::table('hotels')->truncate();
        DB::table('rooms')->truncate();
        DB::table('extras')->truncate();
        DB::table('bookings')->truncate();
        DB::table('extra_hotel')->truncate();
        DB::table('extra_booking')->truncate();

        $this->call(UsersSeeder::class);
        $this->call(HotelsSeeder::class);
        $this->call(RoomsSeeder::class);
        $this->call(extrasSeeder::class);
        $this->call(BookingsSeeder::class);
    }
}
