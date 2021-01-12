<?php

namespace Database\Factories\ProductDetails;

use App\Models\ProductDetails\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArtistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(8),
            'discogs_id' => $this->faker->randomNumber(6),
            'description' => $this->faker->paragraph(rand(3, 6)),
        ];
    }
}
