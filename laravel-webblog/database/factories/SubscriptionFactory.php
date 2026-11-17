<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,

            // if no id found, run migrate again. (geen premium articles, lage kans.)
            'article_id' => Article::where('premium', 1)->inRandomOrder()->first()->id,
        ];
    }
}
