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
        return ArticleResource::make(Article::create($request->validated()))
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
