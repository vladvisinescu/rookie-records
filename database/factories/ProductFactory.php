<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $title = $this->faker->sentence(random_int(3, 8));
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'uuid' => $this->faker->uuid,
            'description' => $this->faker->paragraph(),
            'product_type' => 'vinyl',
            'price' => random_int(5, 25),
            'status' => 'published',
            'published_at' => now()
        ];
    }
}
