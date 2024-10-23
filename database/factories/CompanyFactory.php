<?php

namespace Database\Factories;

use Faker\Core\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
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
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'logo' => $this->faker->url(),
            'type' => random_int(1, 3),
            'description' => $this->faker->text(),
            'domain' => $this->faker->url(),
            'employess_count' => random_int(50, 300)
        ];
    }
}
