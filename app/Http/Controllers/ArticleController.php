<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetArticleRequest;
use App\Http\Requests\PostArticleRequest;
use App\Http\Requests\PutArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(GetArticleRequest $request): JsonResponse
    {
        $articleList = Article::getArticleList($request->validated());

        return ArticleResource::collection($articleList)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostArticleRequest  $request
     * @return JsonResponse
     */
    public function store(PostArticleRequest $request): JsonResponse
    {
        $params = $request->validated();

        $params['trailer_url'] = $params['trailerUrl'];
        $params['release_date'] = $params['releaseDate'];

        return ArticleResource::make(Article::create($params))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Article  $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        return ArticleResource::make($article)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PutArticleRequest  $request
     * @param  Article  $article
     * @return JsonResponse
     */
    public function update(PutArticleRequest $request, Article $article): JsonResponse
    {
        $body = $request->all();

        if (isset($body['title'])) {
            $article->title = $body['title'];
        }

        if (isset($body['description'])) {
            $article->description = $body['description'];
        }

        if (isset($body['format'])) {
            $article->format = $body['format'];
        }

        if (isset($body['rate'])) {
            $article->rate = $body['rate'];
        }

        if (isset($body['trailerUrl'])) {
            $article->trailer_url = $body['trailerUrl'];
        }

        if (isset($body['releaseDate'])) {
            $article->release_date = $body['releaseDate'];
        }

        $article->update($body);

        return ArticleResource::make($article)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return Response
     */
    public function destroy(Article $article): Response
    {
        $article->delete();

        return response([], 204);
    }
}
