<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
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
        Attribute::insert(
            [
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
            ]
        );

        AttributeValue::insert(
            [
                [
                    "attribute_id" => "2",
                    "name" => "Black",
                    "slug" => "c-1",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "2",
                    "name" => "Blue",
                    "slug" => "c-2",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "2",
                    "name" => "Yellow",
                    "slug" => "c-3",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "2",
                    "name" => "White",
                    "slug" => "c-9",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "2",
                    "name" => "Red",
                    "slug" => "c-8",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "2",
                    "name" => "Pink",
                    "slug" => "c-6",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "3",
                    "name" => "40",
                    "slug" => "size 40",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "3",
                    "name" => "41",
                    "slug" => "size 41",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "3",
                    "name" => "42",
                    "slug" => "size 42",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "3",
                    "name" => "43",
                    "slug" => "size 43",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "4",
                    "name" => "Free",
                    "slug" => "free",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "5",
                    "name" => "S",
                    "slug" => "size S",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "5",
                    "name" => "M",
                    "slug" => "size M",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    "attribute_id" => "5",
                    "name" => "L",
                    "slug" => "size L",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
