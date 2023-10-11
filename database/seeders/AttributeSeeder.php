<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attribute::insert([
            [
                "name" => "Size",
                "slug" => "Kích cỡ",
                "descriptions" => "Kích cỡ của sản phẩm",
                "replace_id" => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Color",
                "slug" => "Màu sắc",
                "descriptions" => "Màu sắc của sản phẩm",
                "replace_id" => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Size Giày",
                "slug" => "Size Giày",
                "descriptions" => "Size Giày",
                "replace_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Size Túi & Phụ kiện",
                "slug" => "Size Túi & Phụ kiện",
                "descriptions" => "Size Túi & Phụ kiện",
                "replace_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Size Set",
                "slug" => "Size Set",
                "descriptions" => "Size Set",
                "replace_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
