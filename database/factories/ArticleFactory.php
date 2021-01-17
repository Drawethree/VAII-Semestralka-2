<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
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
            'user_id' => User::inRandomOrder()->get()->first()->id,
            'title' => $this->faker->realText(30, $indexSize = 2),
            'text' => $this->faker->text,
            'approved' => $this->faker->boolean ? 1 : 0,
        ];
    }
}
