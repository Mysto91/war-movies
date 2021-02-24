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
            'description' => 'ma description',
            'format' => 'dvd',
            'rate' => '4.5'
        ];

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);

        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', $body);
        $this->assertEquals($body['title'], $data['title']);
        $this->assertEquals($body['description'], $data['description']);
        $this->assertEquals($body['format'], $data['format']);
        $this->assertEquals($body['rate'], $data['rate']);
    }

    public function testIfPostWithWrongBodyNotWork()
    {
        $user = $this->getUser();

        $body = [
            'title' => 'mon titre',
            'description' => 'ma description'
        ];

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);
        $response->assertStatus(422);

        $expected = [
            "format" => [
                "The format field must be present."
            ],
            "rate" => [
                "The rate field must be present."
            ]
        ];

        $this->assertEquals(json_encode($expected), $response->getContent());
    }

    public function testIfPostWithoutNotAuthenticatedNotWork()
    {
        $response = $this->json('POST', $this->getUrl(123456), []);
        $response->assertStatus(401);
    }
}
