<?php

namespace Database\Factories;

use App\Models\Feed;
use App\Models\FoodCatalog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'served_at' => $this->faker->time(),
            'amount' => $this->faker->randomFloat(2, 5, 50),
            'memo' => $this->faker->sentence(10),
            'user_id' => $user->id,
            'food_id' => FoodCatalog::factory(
                [
                    'user_id' => $user->id,
                ]
            ),
        ];
    }

    /**
     * @var string Model
     */
    protected $model = Feed::class;
}
