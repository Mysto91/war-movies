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

    private function formatBody()
    {
        $faker = $this->getFaker();

        return [
            'title' => $faker->name,
            'description' => $faker->text(100),
            'format' => $faker->randomElement(['dvd', 'blu-ray']),
            'rate' => $faker->randomFloat(1, 0, 5),
            'releaseDate' => $faker->date(),
            'trailerUrl' => $faker->url,
            'imageUrl' => $faker->url
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfPutWorks()
    {
        $user = $this->getUser();

        $article = $this->getArticle();

        $body = $this->formatBody();

        $response = $this->json('PUT', $this->getUrl($article->id, $user->api_token), $body);

        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $response->assertStatus(201);

        $this->assertSame($body['title'], $data['title']);
        $this->assertSame($body['description'], $data['description']);
        $this->assertSame($body['format'], $data['format']);
        $this->assertEquals($body['rate'], $data['rate']);
        $this->assertSame($body['releaseDate'], $data['releaseDate']);
        $this->assertSame($body['trailerUrl'], $data['trailerUrl']);
        $this->assertSame($body['imageUrl'], $data['imageUrl']);
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
        $this->assertSame(['404' => 'The article does not exist.'], $response->original);
    }

    public function testIfPutWithoutNotAuthenticatedNotWork()
    {
        $article = $this->getArticle();

        $response = $this->json('PUT', $this->getUrl($article->id, 123456), []);
        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }

    public function testIfPutWithWrongParamFormatNotWork()
    {
        $article = $this->getArticle();

        $user = $this->getUser();

        $body = $this->formatBody();
        $body['format'] = 'wrong';

        $response = $this->json('PUT', $this->getUrl($article->id, $user->api_token), $body);

        $expected = [
            'format' => ['The format must be dvd or blu-ray.']
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), $response->getContent());
    }
}
