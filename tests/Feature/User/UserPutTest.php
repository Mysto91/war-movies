<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPutTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl($id)
    {
        return "{$this->url}/{$id}";
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

        $response = $this->json('PUT', $this->getUrl($user->id), $body);
        $data = $response->original;

        $response->assertStatus(201);
        $this->assertEquals($body['name'], $data['name']);
        $this->assertEquals($body['email'], $data['email']);
    }

    public function testIfPutWithNotExistingUserWorks()
    {
        $faker = $this->getFaker();

        $body = [
            'name' => $faker->name,
            'email' => $faker->email(),
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('PUT', $this->getUrl(9999), $body);

        $response->assertStatus(404);
        $this->assertEquals(['404' => 'The user does not exist.'], $response->original);
    }
}
