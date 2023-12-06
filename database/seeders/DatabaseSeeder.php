<?php

namespace Database\Seeders;

use App\Models\Market\ProductCategory;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(20)->create();    
        ProductCategory::factory(1)->create();
    }
}
