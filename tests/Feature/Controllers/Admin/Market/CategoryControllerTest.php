<?php

namespace Tests\Feature\Controllers\Admin\Market;

use Tests\TestCase;
use App\Models\User;
use App\Models\Market\ProductCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    //admin.market.categories.index

    public function test_can_see_index(): void
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.market.categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.market.categories.index');
    }

    public function test_does_index_has_productCategories()
    {
        ProductCategory::factory()->count(1)->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.market.categories.index'));
        $response->assertViewHas('productCategories');
    }
}
