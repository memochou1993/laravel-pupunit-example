<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class PostControllerTest extends TestCase
{
    protected $repositoryMock = null;

    public function setUp()
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock('App\Repositories\PostRepository');

        $this->app->instance('App\Repositories\PostRepository', $this->repositoryMock);
    }

    public function testPostList()
    {
        $this->repositoryMock
            ->shouldReceive('latestPost')
            ->once()
            ->andReturn([]);

        $response = $this->get('/posts');

        $response->assertStatus(200);

        $response->assertViewHas('posts');
    }

    public function testCreatePostSuccess()
    {
        $this->repositoryMock
            ->shouldReceive('create')
            ->once();

        $response = $this->post('/posts', [
            'title' => 'title 999',
            'content' => 'content 999',
        ]);
        
        $response->assertStatus(302);

        $response->assertRedirect('/posts');
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
