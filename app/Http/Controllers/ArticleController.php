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
     * @OA\Get(
     *      path="/articles",
     *      operationId="getAllArticles",
     *      tags={"Tests"},

     *      summary="Get list of articles",
     *      description="Returns all articles.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data", 
     *                  type="array", 
     *                  @OA\Items(ref="#/components/schemas/Article")
     *          )
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * 
     * @param  GetArticleRequest  $request
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
     * @OA\Post(
     *      path="/articles",
     *      operationId="createArticle",
     *      tags={"Tests"},

     *      summary="Create an article",
     *      description="Create an article.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     *
     * @param  PostArticleRequest  $request
     * @return JsonResponse
     */
    public function store(PostArticleRequest $request): JsonResponse
    {
        $params = $request->validated();

        $params['trailer_url'] = $params['trailerUrl'];
        $params['image_url'] = $params['imageUrl'];
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

        if (isset($body['imageUrl'])) {
            $article->image_url = $body['imageUrl'];
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
