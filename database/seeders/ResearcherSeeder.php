<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Researcher ;

class ResearcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Researcher::create([
            'name' => 'nouur',
            'email' => 'nour@gmail.com',
            'password' => bcrypt('password'), // تأكد من تشفير كلمة المرور
            'phone' => '+96354668458',
             'code'=>'1111',
             'image'=>'hgfds.jpj',
             'points'=>'5',
             'facebook'=>'dvbfbfb',
             'linkedin'=>'hgfrtyui',
             'github'=>'mnbvc',
        ]);
    }
}
