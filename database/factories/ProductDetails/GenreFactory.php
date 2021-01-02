<?php

namespace Database\Factories\ProductDetails;

use App\Models\ProductDetails\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ucwords(implode(' ', $this->faker->words(rand(1, 3))));

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(8),
            'description' => $this->faker->paragraph(rand(1, 4)),
        ];
    }
}
