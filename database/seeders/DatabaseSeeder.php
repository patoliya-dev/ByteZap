<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = [
            [
                'name' => 'Yogesh',
                'email' => 'yogesh@gmail.com'
            ],
            [
                'name' => 'Ketan',
                'email' => 'Ketan@gmail.com'
            ],
            [
                'name' => 'namita',
                'email' => 'namita@gmail.com'
            ],
            [
                'name' => 'kiran',
                'email' => 'kiran@gmail.com'
            ]
        ];

        foreach($user as $key => $value){
            User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => bcrypt('password'), // default password
                'profile_image' => 'profiles/dY1VP2QOGmXMWtLi6hJwErQ6z69omaEkbPdpTbvg.png',
                'is_admin' => false,
            ]);
        }
        $this->call([
            AttendanceSeeder::class,
        ]);
    }
}
