<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                "email" => "admin@gmail.com",
                "username" => "admin",
                "password" => "$2y$10$4Qi7YDnqmz5W4xzJlENTa.0olHCFguwsc4233HCDlcKXGt25fB9hm",
                "gender" => "male",
                "level" => "admin",
                "status" => "active",
                "last_login" => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
