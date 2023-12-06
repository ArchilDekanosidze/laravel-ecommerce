<?php

namespace Database\Seeders\Market;

use Illuminate\Database\Seeder;
use App\Models\Market\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::factory(3)->create();
        ProductCategory::factory(3)->randomParentId()->create();
        ProductCategory::factory(3)->randomParentId()->create();
    }
}
