<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleGetTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/articles';

    public function getUrl($apiToken)
    {
        return "{$this->url}?api_token=$apiToken";
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfGetWorks()
    {
        $user = $this->getUser();

        $this->getArticleList(5);

        $response = $this->get($this->getUrl($user->api_token));

        $response->assertStatus(200);
        $this->assertEquals(5, sizeof($response->original));
    }

    public function testIfGetWithNoArticleWorks()
    {
        $user = $this->getUser();

        $response = $this->get($this->getUrl($user->api_token));

        $response->assertStatus(200);
        $this->assertEquals(0, sizeof($response->original));
    }

    public function testIfGetWithoutNotAuthenticatedNotWork()
    {
        $response = $this->get($this->getUrl(123456));

        $response->assertStatus(401);
        $this->assertEquals(['401' => 'Unauthenticated.'], $response->original);
    }
}
