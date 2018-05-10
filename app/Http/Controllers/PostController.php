<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $posts = $this->repository->latestPost();

        return view('post.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('posts.index');
    }
}
