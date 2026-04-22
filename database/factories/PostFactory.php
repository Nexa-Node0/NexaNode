<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
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
        $title = $this->faker->sentence(6);
        return [
            'title'            => $title,
            'slug'             => Str::slug($title),
            'content'          => $this->faker->paragraph(4),
            'thumbnail'        => $this->faker->imageUrl(),
            'is_headline'      => $this->faker->boolean(20),
            'tags'             => implode(',', $this->faker->words(3)),
            'status'           => $this->faker->randomElement(\App\Enums\PostStatus::options()),
            'published_date'   => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id'          => \App\Models\User::inRandomOrder()->value('id'),
            'post_category_id' => \App\Models\PostCategory::inRandomOrder()->value('id')
        ];
    }
}
