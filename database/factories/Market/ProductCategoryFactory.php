<?php

namespace Database\Factories\Market;

use Illuminate\Http\UploadedFile;
use App\Models\Market\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => $this->saveImageProccess(),
            'tags' => $this->faker->word(3),
            'parent_id' => null
        ];
    }

    private function saveImageProccess()
    {
        $imageService = app()->make(ImageServiceInterface::class);
        $image =  UploadedFile::fake()->image('file1.png', 600, 600);
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
        return $imageService->createIndexAndSave($image);
    }

    public function randomParentId(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => ProductCategory::inRandomOrder()->value('id'),
            ];
        });
    }
}
