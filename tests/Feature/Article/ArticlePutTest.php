<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePutTest extends TestCase
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
    public function testIfPutWorks()
    {
        $user = $this->getUser();

        $faker = $this->getFaker();

        $body = [
            'title' => $faker->name,
            'description' => $faker->text(100),
            'format' => $faker->randomElement(['dvd', 'blu-ray']),
            'rate' => $faker->randomFloat(1, 0, 5),
            'releaseDate' => $faker->date(),
            'trailerUrl' => $faker->url,
            'imageUrl' => $faker->url
        ];

        $article = $this->getArticle();

        $response = $this->json('PUT', $this->getUrl($article->id, $user->api_token), $body);

        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $response->assertStatus(201);

        $this->assertEquals($body['title'], $data['title']);
        $this->assertEquals($body['description'], $data['description']);
        $this->assertEquals($body['format'], $data['format']);
        $this->assertEquals($body['rate'], $data['rate']);
        $this->assertEquals($body['releaseDate'], $data['releaseDate']);
        $this->assertEquals($body['trailerUrl'], $data['trailerUrl']);
        $this->assertEquals($body['imageUrl'], $data['imageUrl']);
    }

    public function testIfPutWithNotExistingArticleNotWork()
    {
        $user = $this->getUser();

        $body = [
            'title' => 'nouveau titre',
            'description' => 'nouvelle description'
        ];

        $response = $this->json('PUT', $this->getUrl(999999, $user->api_token), $body);

        $response->assertStatus(404);
        $this->assertEquals(['404' => 'The article does not exist.'], $response->original);
    }

    public function testIfPutWithoutNotAuthenticatedNotWork()
    {
        $article = $this->getArticle();

        $response = $this->json('PUT', $this->getUrl($article->id, 123456), []);
        $response->assertStatus(401);
        $this->assertEquals(['401' => 'Unauthenticated.'], $response->original);
    }
}
