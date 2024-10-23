<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Specialization;
use App\Models\CompanySpecialization;
use App\Models\Product;
use App\Models\Researcher;
use App\Models\Report;

use Illuminate\Database\Seeder;

class SeedData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialization::factory()->count(10)->create();
        Company::factory()->count(50)->create();
        CompanySpecialization::factory()->count(50)->create();
        Product::factory()->count(100)->create();
        Researcher::factory()->count(200)->create();
        Report::factory()->count(150)->create();
    }
}
