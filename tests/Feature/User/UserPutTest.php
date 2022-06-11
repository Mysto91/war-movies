<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPutTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl($id, $params = [])
    {
        return $this->getUrlWithParams("{$this->url}/{$id}", $params);
    }

    public function testIfPutWorks()
    {
        $user = $this->getUser();

        $faker = $this->getFaker();

        $body = [
            'name' => $faker->name,
            'email' => $faker->email(),
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('PUT', $this->getUrl($user->id, ['api_token' => $user->api_token]), $body);
        $data = $response->original;

        $response->assertStatus(201);
        $this->assertSame($body['name'], $data['name']);
        $this->assertSame($body['email'], $data['email']);
    }

    public function testIfPutWithNotExistingUserWorks()
    {
        $user = $this->getUser();

        $faker = $this->getFaker();

        $body = [
            'name' => $faker->name,
            'email' => $faker->email(),
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('PUT', $this->getUrl(9999, ['api_token' => $user->api_token]), $body);

        $response->assertStatus(404);
        $this->assertSame(['404' => 'The user does not exist.'], $response->original);
    }

    public function testIfPutWithNotAuthenticatedNotWork()
    {
        $user = $this->getUser();

        $response = $this->put($this->getUrl($user->id));

        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }
}
