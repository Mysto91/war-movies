<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostArticleRequest  $request
     * @return Response
     */
    public function store(PostArticleRequest $request)
    {
        $body = $request->all();

        $article = new Article();

        $article->title = $body['title'];
        $article->description = $body['description'];

        $article->save();

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Article  $article
     * @return Response
     */
    public function show(Article $article)
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
    public function update(PutArticleRequest $request, Article $article)
    {
        $body = $request->all();

        $article->update($body);

        return response()->json($article, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([], 204);
    }
}
