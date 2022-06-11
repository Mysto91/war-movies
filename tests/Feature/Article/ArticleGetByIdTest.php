<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleGetByIdTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/articles';

    public function getUrl($id, $apiToken)
    {
        return "{$this->url}/$id?api_token=$apiToken";
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfGetWorks()
    {
        $user = $this->getUser();

        $article = $this->getArticle();

        $response = $this->get($this->getUrl($article->id, $user->api_token));

        $response->assertStatus(200);

        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $this->assertSame($article->id, $data['id']);
        $this->assertStringContainsString($this->url . '/' . $article->id, $data['_links'][0]['href']);
        $this->assertStringContainsString($this->url, $data['_links'][1]['href']);
    }

    public function testIfGetWithoutNotAuthenticatedNotWork()
    {
        $article = $this->getArticle();

        $response = $this->get($this->getUrl($article->id, 1234));

        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }

    public function testIfGetWithNotExistingArticleNotWork()
    {
        $user = $this->getUser();

        $this->getArticle();

        $response = $this->get($this->getUrl(9999, $user->api_token));

        $response->assertStatus(404);
        $this->assertSame(['404' => 'The article does not exist.'], $response->original);
    }
}
