<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetArticleRequest;
use App\Http\Requests\PostArticleRequest;
use App\Http\Requests\PutArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(GetArticleRequest $request) : Response
    {
        $articleList = Article::getArticleList($request->validated());
        return response($articleList)
                ->header('X-Total-Count', (string) sizeof($articleList));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostArticleRequest  $request
     * @return Article
     */
    public function store(PostArticleRequest $request) : Article
    {
        return Article::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  Article  $article
     * @return Article
     */
    public function show(Article $article) : Article
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PutArticleRequest  $request
     * @param  Article  $article
     * @return Response
     */
    public function update(PutArticleRequest $request, Article $article) : Response
    {
        $body = $request->all();

        $article->update($body);

        return response($article, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return Response
     */
    public function destroy(Article $article) : Response
    {
        $article->delete();

        return response([], 204);
    }
}
