<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGetByIdTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl($id, $apiToken)
    {
        return "{$this->url}/$id?api_token=$apiToken";
    }

    public function testIfGetWorks()
    {
        $user = $this->getUser();

        $response = $this->get($this->getUrl($user->id, $user->api_token));
        $responseBody = $response->decodeResponseJson();

        $data = $responseBody['data'];

        $response->assertStatus(200);
        $this->assertEquals($user->id, $data['id']);
        $this->assertStringContainsString("{$this->url}/{$user->id}", $data['_links'][0]['href']);
        $this->assertStringContainsString($this->url, $data['_links'][1]['href']);
    }

    public function testIfGetWithNotExistingArticleNotWork()
    {
        $user = $this->getUser();

        $response = $this->get($this->getUrl(9999, $user->api_token));

        $response->assertStatus(404);
        $this->assertEquals(['404' => 'The user does not exist.'], $response->original);
    }

    public function testIfGetWithNotAuthenticatedNotWork()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl($user->id, '1234'));

        $response->assertStatus(401);
        $this->assertEquals(['401' => 'Unauthenticated.'], $response->original);
    }
}
