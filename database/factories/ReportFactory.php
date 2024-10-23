<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Researcher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = Product::pluck('id')->toArray();
        $researchers = Researcher::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        $statuses = ['pending', 'accept', 'reject', 'done'];
        return [
            'product_id' => $products[random_int(0, count($products) - 1)],
            'researcher_id' => $researchers[random_int(0, count($researchers) - 1)],
            'title' => $this->faker->sentence,
            'file' => $this->faker->url(),
            'status' => $statuses[random_int(0, count($statuses) - 1)],
            'review_status' =>  1,
            'user_id' => $users[random_int(0, count($users) - 1)],
            'canceled_note' => null
        ];
    }
}
