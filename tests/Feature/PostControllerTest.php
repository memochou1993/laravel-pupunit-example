<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
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

    public function testCsrfFailed()
    {
        $response = $this->post('/posts');

        $response->assertStatus(500);
    }

    public function testCreatePostSuccess()
    {
        $this->repositoryMock
            ->shouldReceive('create')
            ->once();

        Session::start();

        $response = $this->post('/posts', [
            'title' => 'title 999',
            'content' => 'body 999',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect('/posts');
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
