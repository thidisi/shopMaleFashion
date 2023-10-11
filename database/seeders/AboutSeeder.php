<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::insert([
            [
                "title" => "The customer is at the heart of our unique business model, which includes design.",
                "phone" => "0303030303",
                "email" => "shopdemo@gmail.com",
                "logo" => "logoShop/fprl6Mbx2qHlh7W5tC2M06JV8RH65GA1QwtCaVll.png",
                "address" => "Hà Nội",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
