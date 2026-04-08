<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Homepage::class)->name('homepage');
Route::get('/blogs', App\Livewire\Blog\PostIndex::class)->name('blogs.index');