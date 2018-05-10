<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\PostRepository;
use App\Post;

class PostRepositoryTest extends TestCase
{
    protected $repository = null;

    public function setUp()
    {
        parent::setUp();

        $this->initDatabase();
        
        $this->seedData();

        $this->repository = new PostRepository();
    }

    protected function seedData()
    {
        for ($i = 1; $i <= 100; $i ++) {
            Post::create([
                'title' => 'title ' . $i,
                'content'  => 'content ' . $i,
            ]);
        }
    }

    public function testFetchLatestPost()
    {
        $posts = $this->repository->latestPost();

        $this->assertEquals(1, count($posts));

        $i = 100;
        foreach ($posts as $post) {
            $this->assertEquals('title ' . $i, $post->title);
            $i -= 1;
        }
    }

    public function testCreatePost()
    {
        $postCount = $this->repository->postCount();

        $latestId = $postCount + 1;

        $post = $this->repository->create([
            'title' => 'title ' . $latestId,
            'content'  => 'content ' . $latestId,
        ]);

        $this->assertEquals($postCount + 1, $post->id);
    }

    public function tearDown()
    {
        $this->resetDatabase();

        $this->repository = null;
    }
}