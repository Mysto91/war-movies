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
     * @return void
     */

    public function getUrl($id)
    {
        return $this->url . '/' . $id;
    }

    public function testIfDeleteWorks()
    {
        $article = Article::factory()->create();

        $response = $this->delete($this->getUrl($article->id));

        $response->assertStatus(204);
    }
}
