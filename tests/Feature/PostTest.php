<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;

class PostTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->initDatabase();
    }

    public function testEmptyResult()
    {
        $posts = Post::get();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $posts);

        $this->assertEquals(0, $posts->count());
    }

    public function testCreateAndList()
    {
        for ($i = 1; $i <= 10; $i ++) {
            Post::create([
                'title' => 'title ' . $i,
                'content'  => 'content ' . $i,
            ]);
        }

        $posts = Post::all();

        $this->assertEquals(10, $posts->count());
    }

    public function tearDown()
    {
        $this->resetDatabase();
    }
}
