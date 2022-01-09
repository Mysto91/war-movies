<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Article::create([
                'title' => $faker->catchPhrase,
                'description' => $faker->realText(150),
                'rate' => $faker->randomFloat(1, 0, 5),
                'format' => $faker->randomElement(['dvd', 'blu-ray']),
                'trailer_url' => $faker->url,
                'release_date' => $faker->dateTimeBetween()
            ]);
        }
    }
}
