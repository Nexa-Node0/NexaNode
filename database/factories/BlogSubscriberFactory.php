<?php

namespace Database\Factories;

use App\Models\BlogSubscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogSubscriber>
 */
class BlogSubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BlogSubscriber::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'can_receive_updates' => fake()->randomDigit() > 10 ? true : false
        ];
    }
}
