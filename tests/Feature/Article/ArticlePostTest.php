<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlePostTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/articles';

    public function getUrl($apiToken)
    {
        return $this->url . '?api_token=' . $apiToken;
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfPostWorks()
    {
        $user = $this->getUser();

        $body = [
            'title' => 'mon titre',
            'description' => 'ma description'
        ];

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);

        $original = $response->original;

        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', $body);
        $this->assertEquals($body['title'], $original['title']);
        $this->assertEquals($body['description'], $original['description']);
    }

    public function testIfPostWithWrongBodyNotWork()
    {
        $user = $this->getUser();

        $body = [
            'description' => 'ma description'
        ];

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);
        $response->assertStatus(422);
        $this->assertEquals('The given data was invalid.', $response->original['message']);
        $this->assertEquals('The title field is required.', $response->original['errors']['title'][0]);
    }

    public function testIfPostWithoutNotAuthenticatedNotWork()
    {
        $response = $this->json('POST', $this->getUrl(123456), []);
        $response->assertStatus(401);
    }
}
