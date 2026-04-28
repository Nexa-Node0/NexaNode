<?php

namespace App\Livewire\Blog;

use App\Enums\PostStatus;
use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostIndex extends Component
{

    public $posts;
    public $postHeadline;
    public $recommendedPost;
    public $otherPosts;
    
    public $selectedCategoryValue = 'all';

    public function mount()
    {
        $this->posts = Post::where('status', PostStatus::Published->value)
                    ->get()
                    ->map(fn ($record) => $this->formatPost($record));

        $this->postHeadline = $this->formatPost(Post::where('is_headline', true)->first());

        $this->recommendedPost = Post::where('post_category_id', '=', $this->postHeadline->post_category_id)
                                    ->get()
                                    ->map(fn ($record) => $this->formatPost($record));

        $this->otherPosts = Post::where('post_category_id', '!=', $this->postHeadline->post_category_id)
                                    ->limit(4)
                                    ->latest()
                                    ->get()
                                    ->map(fn ($record) => $this->formatPost($record));
    }

    public function formatPost($post){
        if(!$post){
            return null;
        }

        $post->thumbnail = $post->thumbnail
            ? Storage::url($post->thumbnail)
            : asset('images/logos/NEXANODE_LOGO.png');

        return $post;
    }

    public function render()
    {
        return view('livewire.blog.post-index');
    }
}
