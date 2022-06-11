<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPostTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl()
    {
        return $this->url;
    }

    public function testIfPostWorks()
    {
        $faker = $this->getFaker();

        $body = [
            'name' => $faker->name,
            'email' => $faker->email(),
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('POST', $this->getUrl(), $body);
        $data = $response->original;

        $response->assertStatus(201);
        $this->assertSame($body['name'], $data['name']);
        $this->assertSame($body['email'], $data['email']);
    }

    public function testIfPostWithWrongBodyNotWork()
    {
        $body = [
            'wrong' => 'wrong'
        ];

        $response = $this->json('POST', $this->getUrl(), $body);

        $expected = [
            "name" => [
                "The name field is required."
            ],
            "email" => [
                "The email field is required."
            ],
            "password" => [
                "The password field is required."
            ]
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), $response->getContent());
    }

    public function testIfPostWithAlreadyExistingNameNotWork()
    {
        $user = $this->getUser();

        $faker = $this->getFaker();

        $body = [
            'name' => $user->name,
            'email' => $faker->email(),
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('POST', $this->getUrl(), $body);

        $expected = [
            'name' => [
                'The name has already been taken.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), $response->getContent());
    }

    public function testIfPostWithAlreadyExistingEmailNotWork()
    {
        $user = $this->getUser();

        $faker = $this->getFaker();

        $body = [
            'name' => $faker->name(),
            'email' => $user->email,
            'password' => bcrypt($faker->password(5, 10)),
        ];

        $response = $this->json('POST', $this->getUrl(), $body);

        $expected = [
            'email' => [
                'The email has already been taken.'
            ]
        ];

        $response->assertStatus(422);
        $this->assertSame(json_encode($expected), $response->getContent());
    }
}
