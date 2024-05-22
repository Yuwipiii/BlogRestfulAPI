<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>$this->faker->randomElement(User::all()->pluck('id')->toArray()),
            'title'=>$this->faker->sentence(),
            'content'=>$this->faker->paragraph(),
            'published_at'=>$this->faker->date('Y-m-d', 'now'),
            'published'=>$this->faker->boolean(),
        ];
    }
}
