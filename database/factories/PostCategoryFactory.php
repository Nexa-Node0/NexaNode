<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
/**
 * @extends Factory<PostCategory>
 */
class PostCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Predefined realistic categories
        $categories = [
            'Technology', 
            'Health & Wellness', 
            'Travel', 
            'Food & Recipes',
            'Business', 
            'Lifestyle', 
            'Education', 
            'Entertainment',
            'Sports', 
            'Science',
            'Politics', 
            'Finance',
            'Art & Culture', 
            'Environment', 
            'Fashion',
        ];
        
        $category = fake()->unique()->randomElement($categories);

        return [
            'name' => $category,
            'slug' => Str::slug($category),
            'description' => fake()->sentence(10)
        ];
    }
}
