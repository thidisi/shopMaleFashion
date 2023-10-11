<?php

namespace Database\Seeders;

use App\Models\Major_Category;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Major_Category::insert([
            [
                "name" => "Male Shirts",
                "slug" => "male-shirts",
                "status" => "show",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Male Pants",
                "slug" => "male-pants",
                "status" => "show",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Accessories",
                "slug" => "accessories",
                "status" => "show",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Footwears",
                "slug" => "footwears",
                "status" => "show",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "News",
                "slug" => "news",
                "status" => "hot_default",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Hot Sales",
                "slug" => "hot-sales",
                "status" => "hot_default",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
