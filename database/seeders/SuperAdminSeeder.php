<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        User::create([
            'name'=>'Qusai',
                'email'=>'qusai@gmail.com',
                'password'=>'12345678',
                'phone'=>'0962457472',
                'type'=>'super admin',
                'profile_picture'=>'app-assets/images/portrait/small/qusia.jpg'
           
        ]);
    }
}
