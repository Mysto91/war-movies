<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleDeleteTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/articles';
    /**
     * A basic feature test example.
     *
     * @return string
     */

    public function getUrl($id, $apiToken)
    {
        return "{$this->url}/$id?api_token=$apiToken";
    }

    public function testIfDeleteWorks()
    {
        $user = $this->getUser();

        $article = $this->getArticle();

        $response = $this->delete($this->getUrl($article->id, $user->api_token));

        $response->assertStatus(204);
    }

    public function testIfDeleteNotExistingArticleNotWork()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl(1234, $user->api_token));

        $response->assertStatus(404);
        $this->assertEquals(['404' => 'The article does not exist.'], $response->original);
    }

    public function testIfDeleteWithoutNotAuthenticatedNotWork()
    {
        $this->getUser();

        $article = $this->getArticle();

        $response = $this->delete($this->getUrl($article->id, '1234'));

        $response->assertStatus(401);
        $this->assertEquals(['401' => 'Unauthenticated.'], $response->original);
    }
}
