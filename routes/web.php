<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Homepage::class)->name('homepage');

Route::prefix('/about-us')->group(function () {
    Route::get('/blogs', App\Livewire\Blog\PostIndex::class)->name('blogs.index');
});
