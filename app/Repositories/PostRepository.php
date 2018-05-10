<?php

namespace App\Repositories;

use App\Post;

class PostRepository
{
    public function latestPost()
    {
        return Post::orderBy('id', 'desc')->limit(1)->get();
    }

    public function create(array $attributes)
    {
        return Post::create($attributes);
    }

    public function postCount()
    {
        return Post::count();
    }
}