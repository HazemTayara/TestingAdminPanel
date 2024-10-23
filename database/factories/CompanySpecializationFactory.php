<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanySpecialization>
 */
class CompanySpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = Company::pluck('id')->toArray();
        $specializations = Specialization::pluck('id')->toArray();

        return [
            'company_id' => $companies[random_int(0, count($companies) - 1)],
            'specialization_id' => $specializations[random_int(0, count($specializations) - 1)]
        ];
    }
}
