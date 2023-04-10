<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::truncate();

       //definisi
       $faker = \Faker\Factory::create();

       for($i=0 ; $i < 100 ; $i++){
         Post::create(
            [
                'image' => $faker->image(),
                'title' => $faker->title(),
                'contend' => $faker->paragraph(),
            ]
         );
       }
    }
}
