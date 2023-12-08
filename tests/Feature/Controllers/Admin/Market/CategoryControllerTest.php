<?php

namespace Tests\Feature\Controllers\Admin\Market;

use Tests\TestCase;
use App\Models\User;
use Mockery\MockInterface;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Market\ProductCategory;
use App\Services\Category\CategoryService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Category\Contracts\CategoryInterface;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

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
        $this->mockImageServiceInterfaceTimes(1);

        ProductCategory::factory()->count(1)->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.market.categories.index'));
        $response->assertViewHas('productCategories');
    }

    //admin.market.categories.create

    public function test_can_see_create(): void
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.market.categories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.market.categories.create');
    }

    public function test_does_create_has_AllCategories()
    {
        $this->mockImageServiceInterfaceTimes(1);

        ProductCategory::factory()->count(1)->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.market.categories.create'));
        $response->assertViewHas('categories');
    }

    //admin.market.categories.store

    public function test_store_validate_name_required(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => null,
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_name_min_2(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'a',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['name' => __('validation.min.string', ['attribute' => 'name', 'min' => 2])]);

        $response->assertRedirect();
    }

    public function test_store_validate_name_max_120(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => Str::random(121),
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 120])]);

        $response->assertRedirect();
    }


    public function test_store_validate_description_min_5(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);

        $response->assertSessionHasErrors(['description' => __('validation.min.string', ['attribute' => 'description', 'min' => 5])]);

        $response->assertRedirect();
    }

    public function test_store_validate_description_max_500(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'my name',
            'description' => Str::random(501),
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['description' => __('validation.max.string', ['attribute' => 'description', 'max' => 500])]);

        $response->assertRedirect();
    }


    public function test_store_validate_image_required(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => null,
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['image' => __('validation.required', ['attribute' => 'image'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_image_should_be_image(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->create('file1.pdf'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['image' => __('validation.image', ['attribute' => 'image'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_image_mime_png_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }

    public function test_store_validate_image_mime_jpg_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.jpg'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }

    public function test_store_validate_image_mime_jpeg_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.jpeg'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }

    public function test_store_validate_image_mime_gif_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.gif'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }


    public function test_store_validate_image_invalid_mime(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.gifjpg'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['image']);

        $response->assertRedirect();
    }

    public function test_store_validate_status_required(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.required', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_status_should_be_numeric(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 'abc',
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.numeric', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_status_should_be_one_or_zero(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 2,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.in', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }


    public function test_store_validate_show_in_menu_required(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => null,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_store_validate_show_in_menu_should_be_numeric(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 'abc',
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_store_validate_show_in_menu_should_be_one_or_zero(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 2,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_store_validate_tags_required(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => null,
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['tags' => __('validation.required', ['attribute' => 'tags'])]);

        $response->assertRedirect();
    }

    public function test_store_validate_parent_id_can_be_null(): void
    {
        $this->mockImageServiceInterfaceTimes(0);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => null,
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => null,

        ]);
        $response->assertSessionDoesntHaveErrors(['parent_id']);

        $response->assertRedirect();
    }

    public function test_store_validate_parent_id_should_exists_in_product_category_id(): void
    {
        $this->mockImageServiceInterfaceTimes(0);
        $categoryIds = ProductCategory::all()->pluck('id')->toArray();
        $newParentId = $this->generateRandomNumberNotInList($categoryIds);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.market.categories.store'), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => $newParentId,

        ]);
        $response->assertSessionHasErrors(['parent_id']);

        $response->assertRedirect();
    }

    public function test_store_success(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $data = [
            'name' => fake()->name(),
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => fake()->word,
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ];
        $response = $this->post(route('admin.market.categories.store'), $data);


        $response->assertSessionHas(['swal-success' => __('admin.New category has been successfully registered')]);
        $response->assertRedirect(route('admin.market.categories.index'));

        unset($data['image']);

        $this->assertDatabaseHas('product_categories', $data);
    }

    public function test_store_failed(): void
    {
        $mock = $this->mock(CategoryInterface::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('store')->times(1)
                ->andReturn(CategoryInterface::FAILED);
        });

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $data = [
            'name' => fake()->name(),
            'description' => 'cat desck db',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => fake()->word,
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ];
        $response = $this->post(route('admin.market.categories.store'), $data);


        $response->assertSessionHas(['swal-error' => __('admin.There was an error uploading the image')]);
        $response->assertRedirect(route('admin.market.categories.index'));
    }

    //admin.market.categories.edit

    public function test_can_see_edit(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();
        $response = $this->get(route('admin.market.categories.edit', ['productCategory' => $productCategory->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.market.categories.edit');
    }

    public function test_does_edit_has_parent_categories()
    {
        $this->withoutExceptionHandling();
        $this->mockImageServiceInterfaceTimes(2);

        ProductCategory::factory()->count(1)->create();
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->create();
        $response = $this->get(route('admin.market.categories.edit', ['productCategory' => $productCategory->id]));

        $response->assertViewHas('parent_categories');
    }

    //admin.market.categories.update

    public function test_update_validate_name_required(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();


        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => null,
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);

        $response->assertRedirect();
    }


    public function test_update_validate_name_min_2(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'a',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['name' => __('validation.min.string', ['attribute' => 'name', 'min' => 2])]);

        $response->assertRedirect();
    }

    public function test_update_validate_name_max_120(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => Str::random(121),
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 120])]);

        $response->assertRedirect();
    }


    public function test_update_validate_description_min_5(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);

        $response->assertSessionHasErrors(['description' => __('validation.min.string', ['attribute' => 'description', 'min' => 5])]);

        $response->assertRedirect();
    }

    public function test_update_validate_description_max_500(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'my name',
            'description' => Str::random(501),
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);


        $response->assertSessionHasErrors(['description' => __('validation.max.string', ['attribute' => 'description', 'max' => 500])]);

        $response->assertRedirect();
    }




    public function test_update_validate_image_should_be_image(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->create('file1.pdf'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['image' => __('validation.image', ['attribute' => 'image'])]);

        $response->assertRedirect();
    }

    public function test_update_validate_image_mime_png_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }

    public function test_update_validate_image_mime_jpg_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.jpg'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }

    public function test_update_validate_image_mime_jpeg_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.jpeg'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }



    public function test_update_validate_image_mime_gif_is_ok(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.gif'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionDoesntHaveErrors(['image']);

        $response->assertRedirect();
    }


    public function test_update_validate_image_invalid_mime(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.gifjpg'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['image']);

        $response->assertRedirect();
    }

    public function test_update_validate_status_required(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => null,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.required', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }

    public function test_update_validate_status_should_be_numeric(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 'abc',
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.numeric', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }

    public function test_update_validate_status_should_be_one_or_zero(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 2,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['status' => __('validation.in', ['attribute' => 'status'])]);

        $response->assertRedirect();
    }


    public function test_update_validate_show_in_menu_required(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => null,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_update_validate_show_in_menu_should_be_numeric(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 'abc',
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_update_validate_show_in_menu_should_be_one_or_zero(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 2,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['show_in_menu']);

        $response->assertRedirect();
    }

    public function test_update_validate_tags_required(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => null,
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ]);
        $response->assertSessionHasErrors(['tags' => __('validation.required', ['attribute' => 'tags'])]);

        $response->assertRedirect();
    }

    public function test_update_validate_parent_id_can_be_null(): void
    {
        $this->mockImageServiceInterfaceTimes(1);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => null,
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => null,

        ]);
        $response->assertSessionDoesntHaveErrors(['parent_id']);

        $response->assertRedirect();
    }

    public function test_update_validate_parent_id_should_exists_in_product_category_id(): void
    {
        $this->mockImageServiceInterfaceTimes(1);
        $categoryIds = ProductCategory::all()->pluck('id')->toArray();
        $newParentId = $this->generateRandomNumberNotInList($categoryIds);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => $newParentId,

        ]);
        $response->assertSessionHasErrors(['parent_id']);

        $response->assertRedirect();
    }

    public function test_update_success(): void
    {
        $mock = $this->mock(ImageServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteFiles')->times(1);
            $mock->shouldReceive('setExclusiveDirectory')->times(2);
            $mock->shouldReceive('createIndexAndSave')->times(2)
                ->andReturn(['indexArray' => ['large' => 'path', 'medium' => 'path', 'small' => 'path'], 'currentImage' => 'medium']);
        });
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $data = [
            'name' => fake()->name(),
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => fake()->word,
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ];

        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), $data);

        $response->assertSessionHas(['swal-success' => __('admin.The category has been successfully edited')]);
        $response->assertRedirect(route('admin.market.categories.index'));

        unset($data['image']);

        $this->assertDatabaseHas('product_categories', $data);
    }

    public function test_update_failed(): void
    {

        $mock = $this->mock(CategoryInterface::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('update')->times(1)
                ->andReturn(CategoryInterface::FAILED);
        });

        $mock = $this->mock(ImageServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('setExclusiveDirectory')->times(1);
            $mock->shouldReceive('createIndexAndSave')->times(1)
                ->andReturn(['indexArray' => ['large' => 'path', 'medium' => 'path', 'small' => 'path'], 'currentImage' => 'medium']);
        });


        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $data = [
            'name' => 'cat name',
            'description' => 'cat desck',
            'image' => UploadedFile::fake()->image('file1.png'),
            'status' => 1,
            'show_in_menu' => 1,
            'tags' => 'cat tags',
            'parent_id' => ProductCategory::inRandomOrder()->value('id'),

        ];
        $productCategory = ProductCategory::factory()->create();

        $response = $this->put(route('admin.market.categories.update', ['productCategory' => $productCategory->id]), $data);


        $response->assertSessionHas(['swal-error' => __('admin.There was an error uploading the image')]);
        $response->assertRedirect(route('admin.market.categories.index'));
    }


    private function mockImageServiceInterfaceTimes($times)
    {
        $mock = $this->mock(ImageServiceInterface::class, function (MockInterface $mock) use ($times) {
            $mock->shouldReceive('setExclusiveDirectory')->times($times);
            $mock->shouldReceive('createIndexAndSave')->times($times)
                ->andReturn(['indexArray' => ['large' => 'path', 'medium' => 'path', 'small' => 'path'], 'currentImage' => 'medium']);
        });
    }

    private function generateRandomNumberNotInList($list)
    {
        do {
            $rand = rand(0, 100000);
        } while (in_array($rand, $list));
        return $rand;
    }
}
