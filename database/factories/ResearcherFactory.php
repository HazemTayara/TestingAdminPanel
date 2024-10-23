<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Researcher>
 */
class ResearcherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'phone' => $this->faker->phoneNumber,
            'code' => null,
            'image' => $this->faker->imageUrl,
            'points' => random_int(1, 20),
            'facebook' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
            'github' => $this->faker->url()
        ];
    }
}
