<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    private $likes = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        do {
            $like = [
                'user_id' => $this->faker->numberBetween(1, 100),
                'rivista_id' => $this->faker->numberBetween(1, 1000),
            ];
        } while (in_array($like, $this->likes));

        $this->likes[] = $like;

        return $like;
    }
}
