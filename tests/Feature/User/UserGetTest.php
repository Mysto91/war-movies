<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGetTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    private function getUrl($params = [])
    {
        return $this->getUrlWithParams($this->url, $params);
    }

    public function testIfGetWorks()
    {
        $userList = $this->getUserList(3);

        $response = $this->get($this->getUrl(['api_token' => $userList[0]->api_token]));

        $response->assertStatus(200);
        $this->assertCount(count($userList), $response->original);
    }

    public function testIfGetWithPaginationWorks()
    {
        $userList = $this->getUserList(10);

        $params = [
            'page' => 2,
            'perPage' => 3,
            'api_token' => $userList[0]->api_token,
        ];

        $response = $this->get($this->getUrl($params));
        $output = $response->original->toArray();

        $response->assertStatus(200);
        $this->assertCount($params['perPage'], $output);
        $this->assertSame([4, 5, 6], array_column($output, 'id'));
    }

    public function testIfGetWithWongParamPerPageNotWork()
    {
        $user = $this->getUser();

        $params = [
            'perPage' => 'wrong',
            'api_token' => $user->api_token
        ];

        $response = $this->get($this->getUrl($params));

        $expected = [
            'perPage' => [
                'The per page must be an integer.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), json_encode($response->original));
    }

    public function testIfGetWithWongParamPageNotWork()
    {
        $user = $this->getUser();

        $params = [
            'page' => 'wrong',
            'api_token' => $user->api_token
        ];

        $response = $this->get($this->getUrl($params));

        $expected = [
            'page' => [
                'The page must be an integer.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), json_encode($response->original));
    }

    public function testIfGetWithNotAuthenticatedNotWork()
    {
        $user = $this->getUser();

        $response = $this->get($this->getUrl());

        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }
}
