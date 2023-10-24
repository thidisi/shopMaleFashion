<?php

namespace Database\Seeders;

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
        $this->call([
            DistrictSeeder::class,
            ProvinceSeeder::class,
            WardSeeder::class,
            MenuSeeder::class,
            AboutSeeder::class,
            AttributeSeeder::class,
            CategorySeeder::class,
            SlideSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
