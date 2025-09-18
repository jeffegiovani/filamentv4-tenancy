<?php

namespace Database\Factories;

use App\Models\RealEstate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealEstate>
 */
class RealEstateFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RealEstate::class;

    public $totalCities = 10;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => fake()->numberBetween(1, $this->totalCities),
            'name' => fake()->company(),
            'slug' => Str::limit(fake()->slug(), 38, '').uniqid(),
            'address' => fake()->address(),
        ];
    }
}
