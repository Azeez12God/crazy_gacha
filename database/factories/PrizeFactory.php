<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prize>
 */
class PrizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rarity' => $this->faker->randomElement(['Común', 'Rara', 'Especial','Épica','Legendaria']),
            'reward' => $this->faker->numberBetween(1,100),
            'image' => $this->faker->imageUrl(),
            'audio' => $this->faker->word() . '.mp3'
        ];
    }
}
