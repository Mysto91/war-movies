<?php

namespace Tests;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getUser()
    {
        return User::factory()->create();
    }

    protected function getArticle()
    {
        return Article::factory()->create();
    }

    protected function getArticleList($nb)
    {
        return Article::factory($nb)->create();
    }

    protected function getFaker()
    {
        return \Faker\Factory::create();
    }

    protected function getUrlWithParams($url, array $params)
    {
        if (!$params) {
            return $url;
        }

        $paramsConcat = '';

        foreach ($params as $key => $param) {
            $paramsConcat = "{$key}={$param}&{$paramsConcat}";
        }

        return "{$url}?{$paramsConcat}";
    }
}
