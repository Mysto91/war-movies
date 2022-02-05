<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text(),
            'rate' => $this->faker->randomFloat(1, 0, 5),
            'format' => $this->faker->randomElement(['dvd', 'blu-ray']),
            'release_date' => $this->faker->date(),
            'trailer_url' => $this->faker->url,
            'image_url' => $this->faker->url,
        ];
    }
}
