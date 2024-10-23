<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Hazem',
                'email' => 'hazem@gmail.com',
                'phone' => '0944011991',
                'password' => '12345678',
                'remember_token' => '0',
                'type' => 'super admin',
                'profile_picture' => null
            ]
        );
    }
}
