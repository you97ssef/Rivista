<?php

namespace Database\Factories;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement([MediaType::IMAGE, MediaType::VIDEO]),
            'link' => $this->faker->imageUrl(),
            'delete_hash' => $this->faker->realText(16),
        ];
    }
}
