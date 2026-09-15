<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the catalogue with the content the Figma frames were designed around.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PortSeeder::class,
            BoatOperatorSeeder::class,
            HotelSeeder::class,
            ActivitySeeder::class,
            ArticleSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
