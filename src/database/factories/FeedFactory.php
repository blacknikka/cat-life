<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\Feed;
use App\Models\FoodCatalog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class FeedFactory extends Factory
{
    private ?User $user = null;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = $this->user ?: User::factory()->create();

        return [
            'served_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'amount' => $this->faker->randomFloat(2, 5, 50),
            'memo' => $this->faker->sentence(10),
            'cat_id' => Cat::factory(
                [
                    'user_id' => $user->id,
                ]
            ),
            'food_id' => FoodCatalog::factory(
                [
                    'user_id' => $user->id,
                ]
            ),
        ];
    }

    /**
     * Indicate the user who has this Feed.
     *
     * @param int $userId
     * @return FeedFactory
     */
    public function who(int $userId) : FeedFactory
    {
        try {
            $this->user = $userId ? User::findOrFail($userId) : User::factory()->create();
        } catch (\Exception $e) {
            Log::info("cannot find User. id => " . $userId);
        }

        return $this;
    }

    /**
     * @var string Model
     */
    protected $model = Feed::class;
}
