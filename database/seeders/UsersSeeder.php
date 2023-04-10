<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        $password =  Hash::make("admin");

        //create admin user

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => $password,
        ]);


        for($i = 0; $i < 10 ; $i++){
            User::create([
              'name' => $faker->name(),
              'email' => $faker->email(),
              'password' => $faker->password(),
            ]);
        }
    }
}
