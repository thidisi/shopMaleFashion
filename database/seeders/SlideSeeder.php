<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slide::insert([
            [
                "title" => "Fall - Winter Collections 2030",
                "slug" => "A specialist label creating luxury essentials. Ethically crafted with an unwavering.",
                "image" => '["imageSlide\/492w2zilaHmDKnEXqmdyuYEXTPWDvT7IboXr3pff.jpg"]',
                "major_category_id" => 1,
                "sort_order" => "slider",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Instagram",
                "slug" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                "image" => '["imageSlide\/i9eCHRh3j8DK9eE4bJiFEfDLaCjkJqXANA795yHo.jpg","imageSlide\/Htr5rDPmB7GHCWZgoIlh4NJhHIuPnShXHh9AbBjS.jpg","imageSlide\/bZeuBcqFq4mmFRXdTWkFIZfKwasaYFeD9nv9mqIh.jpg","imageSlide\/uF9iNjTUJO2AIKNDFdb7Yy4FKHXTptZbtF0jMTmI.jpg","imageSlide\/Uy4VrDp2qwo8pLKHYQiEIMTmy0HA4uicvtNsSiNE.jpg","imageSlide\/m9QTHdnRCkN4WarR6MUb4U9HmFMhb0upEIQq9Y8T.jpg"]',
                "major_category_id" => 1,
                "sort_order" => "instagram",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Fall - Winter Collections 2030",
                "slug" => "A specialist label creating luxury essentials. Ethically crafted with an unwavering.",
                "image" => '["imageSlide\/z3MSvJ2dzpSfAuy2Nw3fRflzgGslhjravvZvWr8g.jpg"]',
                "major_category_id" => 1,
                "sort_order" => "slider",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Clothing Collections 2030",
                "slug" => "Clothing Collections 2030",
                "image" => '["imageSlide\/J2QXkC6JWYkezwzFRvh7VrcTHiTGtTlDVucPeL7t.jpg"]',
                "major_category_id" => 1,
                "sort_order" => "banner",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Accessories",
                "slug" => "Accessories",
                "image" => '["imageSlide\/RkhFlMUA2ZKXoItn1hqoGjS1pGy07tfBO9KHlGB7.jpg"]',
                "major_category_id" => 3,
                "sort_order" => "banner",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "title" => "Shoes Spring 2030",
                "slug" => "Shoes Spring 2030",
                "image" => '["imageSlide\/zXWQ7Momgd4O35u2Y99CTr6bC9q0n0Wz0ZUJ1vSh.jpg"]',
                "major_category_id" => 4,
                "sort_order" => "banner",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
