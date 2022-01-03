<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl($id)
    {
        return "{$this->url}/$id";
    }

    public function testIfDeleteWorks()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl($user->id));

        $response->assertStatus(204);
    }

    public function testIfDeleteNotExistingUserNotWork()
    {
        $response = $this->delete($this->getUrl(99999));

        $response->assertStatus(404);
        $this->assertEquals(['404' => 'The user does not exist.'], $response->original);
    }
}
