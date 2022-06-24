<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'is_admin' => 1
            ],[
                'name' => 'user',
                'email' => 'a@a.com',
                'password' => bcrypt('12345678'),
            ]
        ];

        foreach ($user as $item) {
            User::create($item);
        }
    }
}
