<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePostTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/articles';

    public function getUrl($apiToken)
    {
        return "{$this->url}?api_token=$apiToken";
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
    public function testIfPostWorks()
    {
        $user = $this->getUser();

        $body = $this->formatBody();

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);

        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $response->assertStatus(201);

        $this->assertSame($body['title'], $data['title']);
        $this->assertSame($body['description'], $data['description']);
        $this->assertSame($body['format'], $data['format']);
        $this->assertEquals($body['rate'], $data['rate']);
        $this->assertSame($body['trailerUrl'], $data['trailerUrl']);
        $this->assertSame($body['imageUrl'], $data['imageUrl']);
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
            ],
            "trailerUrl" => [
                "The trailer url field must be present."
            ],
            "imageUrl" => [
                "The image url field must be present."
            ],
            "releaseDate" => [
                "The release date field must be present."
            ]
        ];

        $this->assertSame(json_encode($expected), $response->getContent());
    }

    public function testIfPostWithoutNotAuthenticatedNotWork()
    {
        $response = $this->json('POST', $this->getUrl(123456), []);

        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }

    public function testIfPosttWithWrongParamFormatNotWork()
    {
        $user = $this->getUser();

        $body = $this->formatBody();
        $body['format'] = 'wrong';

        $response = $this->json('POST', $this->getUrl($user->api_token), $body);

        $expected = [
            'format' => ['The format must be dvd or blu-ray.']
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), $response->getContent());
    }
}
