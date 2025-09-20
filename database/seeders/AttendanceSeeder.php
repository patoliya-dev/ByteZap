<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure we have some users first
        if (User::count() === 0) {
            User::factory(10)->create(); // generate 10 users if not exist
        }

        $type = ['web-came', 'manual'];
        $users = User::all();

        // Loop through last 2 weeks for each user
        foreach ($users as $user) {
            for ($i = 0; $i < 14; $i++) {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => Carbon::today()->subDays($i),
                    'type' => $type[array_rand($type)],
                ]);
            }
        }
    }
}
