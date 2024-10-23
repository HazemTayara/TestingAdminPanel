<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = Company::pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'company_id' => $companies[random_int(0, count($companies) - 1)],
            'status' => random_int(0, 1),
            'terms' => $this->faker->text(),
            'url' => $this->faker->url
        ];
    }
}
