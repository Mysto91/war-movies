<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleGetTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/api/articles';

    public function getUrl($params = [])
    {
        return $this->getUrlWithParams($this->url, $params);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfGetWorks()
    {
        $user = $this->getUser();

        $this->getArticleList(5);

        $response = $this->get($this->getUrl(['api_token' => $user->api_token]));

        $response->assertStatus(200);
        $this->assertEquals(5, sizeof($response->original));
    }

    public function testIfGetWithNoArticleWorks()
    {
        $user = $this->getUser();

        $response = $this->get($this->getUrl(['api_token' => $user->api_token]));

        $response->assertStatus(200);
        $this->assertEquals(0, sizeof($response->original));
    }

    public function testIfGetWithoutNotAuthenticatedNotWork()
    {
        $response = $this->get($this->getUrl(['api_token' => 1234]));

        $response->assertStatus(401);
        $this->assertEquals(['401' => 'Unauthenticated.'], $response->original);
    }

    public function testIfGetWithWongParamPerPageNotWork()
    {
        $user = $this->getUser();

        $params = [
            'api_token' => $user->api_token,
            'perPage' => 'wrong'
        ];

        $response = $this->get($this->getUrl($params));

        $expected = [
            'perPage' => [
                'The per page must be an integer.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertEquals(json_encode($expected), json_encode($response->original));
    }

    public function testIfGetWithWongParamPageNotWork()
    {
        $user = $this->getUser();

        $params = [
            'api_token' => $user->api_token,
            'page' => 'wrong'
        ];

        $response = $this->get($this->getUrl($params));

        $expected = [
            'page' => [
                'The page must be an integer.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertEquals(json_encode($expected), json_encode($response->original));
    }
}
