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

        $response = $this->get($this->getUrl());

        $response->assertStatus(200);
        $this->assertCount(count($userList), $response->original);
    }

    public function testIfGetWithPaginationWorks()
    {
        $this->getUserList(10);

        $params = [
            'page' => 2,
            'perPage' => 3
        ];

        $response = $this->get($this->getUrl($params));
        $output = $response->original->toArray();

        $response->assertStatus(200);
        $this->assertCount($params['perPage'], $output);
        $this->assertEquals([4, 5, 6], array_column($output, 'id'));
    }

    public function testIfGetWithNoUsersWorks()
    {
        $response = $this->get($this->getUrl());

        $response->assertStatus(200);
        $this->assertCount(0, $response->original);
    }

    public function testIfGetWithWongParamPerPageNotWork()
    {
        $params = [
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
        $params = [
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
