<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        return $this->url . '/' . $id . '?api_token=' . $apiToken;
    }

    public function testIfDeleteWorks()
    {
        $user = $this->getUser();

        $article = Article::factory()->create();

        $response = $this->delete($this->getUrl($article->id, $user->api_token));

        $response->assertStatus(204);
    }

    public function testIfDeleteNotExistingArticleNotWork()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl(1234, $user->api_token));

        $response->assertStatus(404);
    }

    public function testIfDeleteWithoutNotAuthenticatedNotWork()
    {
        $user = $this->getUser();

        $article = Article::factory()->create();

        $response = $this->delete($this->getUrl($article->id, '1234'));
        $response->assertStatus(302);
    }
}
