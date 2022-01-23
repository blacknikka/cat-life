<?php

namespace Database\Factories;

use App\Models\FoodCatalog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodCatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'maker' => $this->faker->name(),
            'calorie' => $this->faker->randomFloat(2, 100, 500),
            'memo' => $this->faker->sentence(10),
            'picture' => base64_encode($this->faker->image()),
            'url' => $this->faker->url(),
            'is_master' => false,
            'user_id' => User::factory(),
        ];
    }

    /**
     * @var string Model
     */
    protected $model = FoodCatalog::class;
}
