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
                "title" => "The Health Benefits Of Sunglasses",
                "slug" => "the-health-benefits-of-sunglasses",
                "image" => "imageBlog/kEQ3K3kBp0aqQTd77dRMV5laoMFKU8jHsCG3JAXZ.jpg",
                "content" => "<p>image</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Eternity Bands Do Last Forever",
                "slug" => "eternity-bands-do-last-forever",
                "image" => "imageBlog/Kl9gUoqkNpghhBUPLrC2vtRZ0LxZCVHLSLJBFg03.jpg",
                "content" => "<p>image</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "What Curling Irons Are The Best Ones",
                "slug" => "what-curling-irons-are-the-best-ones",
                "image" => "imageBlog/2EV9ONlQWZgEYmHktko1LjsmXdg5yVcm0JGcOfEM.jpg",
                "content" => "<p>image</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
