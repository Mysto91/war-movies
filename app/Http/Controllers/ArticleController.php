<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Util\Validators\ApiValidator;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    use ApiValidator;

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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $body = $request->all();

        $validator = ApiValidator::validateStoreArticle($body);

        if ($validator !== true) {
            return $validator;
        }

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
     * @param  Request  $request
     * @param  Article  $article
     * @return Response
     */
    public function update(Request $request, Article $article)
    {
        $body = $request->all();

        $validator = ApiValidator::validateUpdateArticle($body);

        if ($validator !== true) {
            return $validator;
        }

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
