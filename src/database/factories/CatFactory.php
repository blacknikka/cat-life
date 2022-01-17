<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatFactory extends Factory
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
            'birth' => $this->faker->date(),
            'description' => $this->faker->sentence(10),
            'picture' => base64_encode($this->faker->image()),
            'user_id' => User::factory(),
        ];
    }

    /**
     * @var string Model
     */
    protected $model = Cat::class;
}
