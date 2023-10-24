<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blog::insert([
            [
                "title " => "The Health Benefits Of Sunglasses",
                "slug" => "the-health-benefits-of-sunglasses",
                "image" => "image",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title " => "Eternity Bands Do Last Forever",
                "slug" => "eternity-bands-do-last-forever",
                "image" => "image",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title " => "What Curling Irons Are The Best Ones",
                "slug" => "what-curling-irons-are-the-best-ones",
                "image" => "image",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
