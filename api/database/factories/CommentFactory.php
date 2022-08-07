<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_id = $this->faker->randomElement([null, $this->faker->numberBetween(1, 10)]);

        if ($user_id) {
            return [
                'text' => $this->faker->text,
                'rivista_id' => $this->faker->numberBetween(1, 1000),
                'user_id' => $user_id,
            ];
        }


        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'text' => $this->faker->text,
            'rivista_id' => $this->faker->numberBetween(1, 1000),
            'user_id' => null,
        ];
    }
}
