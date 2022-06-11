<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase;

    private $url = 'api/users';

    public function getUrl($id, $params = [])
    {
        return $this->getUrlWithParams("{$this->url}/$id", $params);
    }

    public function testIfDeleteWorks()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl($user->id, ['api_token' => $user->api_token]));

        $response->assertStatus(204);
    }

    public function testIfDeleteNotExistingUserNotWork()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl(99999, ['api_token' => $user->api_token]));

        $response->assertStatus(404);
        $this->assertSame(['404' => 'The user does not exist.'], $response->original);
    }

    public function testIfDeleteWithNotAuthenticatedNotWork()
    {
        $user = $this->getUser();

        $response = $this->delete($this->getUrl($user->id, ['api_token' => '1234']));

        $response->assertStatus(401);
        $this->assertSame(['401' => 'Unauthenticated.'], $response->original);
    }
}
