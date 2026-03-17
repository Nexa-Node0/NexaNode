<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Predefined realistic categories
        $categories = [
            'Technology', 'Health & Wellness', 'Travel', 'Food & Recipes',
            'Business', 'Lifestyle', 'Education', 'Entertainment',
            'Sports', 'Science', 'Politics', 'Finance',
            'Art & Culture', 'Environment', 'Fashion',
        ];

        foreach ($categories as $category) {
            DB::table('post_categories')->insert([
                'name'        => $category,
                'slug'        => Str::slug($category),
                'description' => $faker->sentence(10),
            ]);
        }
    }
}
