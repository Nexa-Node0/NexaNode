<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\BlogSubscriber;
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postCategoryCount = $this->command->ask('How many category you want to create?', 10);
        PostCategory::factory((int)$postCategoryCount)->create();
      
        $postCount = $this->command->ask('How many post you want to create?', 10);
        Post::factory((int)$postCount)->create();

        $subscribers = $this->command->ask('How many subscribers you want to create?', 4);
        BlogSubscriber::factory((int)$subscribers)->create();

        $this->command->info("Blog Seeded Successfully");

    }
}
