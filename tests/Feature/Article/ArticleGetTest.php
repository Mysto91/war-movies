<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleGetTest extends TestCase
{

    use RefreshDatabase;

    private $url = '/api/articles';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfGetWorks()
    {

        $articlesList = Article::factory(5)->create();

        $response = $this->get($this->url);

        $response->assertStatus(200);
        $this->assertEquals(5, sizeof($response->original));
    }
}
