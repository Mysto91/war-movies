<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleGetTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/articles';

    public function getUrl($apiToken)
    {
        return $this->url . '?api_token=' . $apiToken;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfGetWorks()
    {
        $user = $this->getUser();

        $articlesList = Article::factory(5)->create();

        $response = $this->get($this->getUrl($user->api_token));

        $response->assertStatus(200);
        $this->assertEquals(5, sizeof($response->original));
    }

    public function testIfGetWithoutNotAuthenticatedNotWork()
    {
        $response = $this->get($this->getUrl(123456));
        $response->assertStatus(302);
    }
}
