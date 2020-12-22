<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlePutTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/articles';

    public function getUrl($id)
    {
        return $this->url . '/' . $id; 
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfPutWorks()
    {
        $body = [
            'title' => 'nouveau titre',
            'description' => 'nouvelle description'
        ];

        $article = Article::factory()->create();

        $response = $this->json('PUT', $this->getUrl($article->id), $body);

        $response->assertStatus(201);
        $this->assertDatabaseHas('article', $body);
    }

    public function testIfPutWithWrongBodyNotWork()
    {
        $body = [
            'description' => 'ma description'
        ];

        $article = Article::factory()->create();

        $response = $this->json('PUT', $this->getUrl($article->id), $body);
        $response->assertStatus(400);
        $this->assertEquals('The title field is required.', $response->original->getMessages()['title'][0]);
    }

    public function testIfPutWithNotExistingArticleNotWork()
    {
        $body = [
            'title' => 'nouveau titre',
            'description' => 'nouvelle description'
        ];

        $response = $this->json('PUT', $this->getUrl(99999), $body);

        $response->assertStatus(404);
        
    }
}
