<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlePostTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/articles';
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfPostWorks()
    {
        $body = [
            'title' => 'mon titre',
            'description' => 'ma description'
        ];

        $response = $this->json('POST', $this->url, $body);

        $response->assertStatus(201);
        $this->assertDatabaseHas('article', $body);
        $this->assertEquals($body['title'], $response->original['title']);
    }

    public function testIfPostWithWrongBodyNotWork()
    {
        $body = [
            'description' => 'ma description'
        ];

        $response = $this->json('POST', $this->url, $body);
        $response->assertStatus(422);
        $this->assertEquals('The given data was invalid.', $response->original['message']);
        $this->assertEquals('The title field is required.', $response->original['errors']['title'][0]);
    }
}
