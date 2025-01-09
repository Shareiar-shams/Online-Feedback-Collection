<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' =>'admin',
                'email' =>'shareiar@example.com',
                'password' => bcrypt('shareiar'),
                'phone'=>'01307665311',
                'image'=>'noimage.jpg',
                'position'=>'Administor',
            ],
        ];

        foreach ($admins as $key => $value) {

            User::create($value);
        }
    }
}
