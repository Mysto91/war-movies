<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetArticleRequest;
use App\Http\Requests\PostArticleRequest;
use App\Http\Requests\PutArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *      path="/articles",
     *      operationId="getAllArticles",
     *      security={"api_key"},
     *      tags={"Articles"},
     *      summary="Get list of articles",
     *      description="Get all articles.",
     *      @OA\Parameter(name="perPage", description="Number per page", in="query"),
     *      @OA\Parameter(name="page", description="Current page", in="query"),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Article")
     *              )
     *          )
     *      ),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest")
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
     *      security={"api_key"},
     *      tags={"Articles"},
     *      summary="Create an article",
     *      description="Create an article.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Article")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Article"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest")
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
     * @OA\Get(
     *      path="/articles/{articleId}",
     *      operationId="getArticleById",
     *      security={"api_key"},
     *      tags={"Articles"},
     *      summary="Get the article.",
     *      description="Get the article.",
     *      @OA\Parameter(name="articleId", description="article id", in="path", required=true),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Article"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest")
     *  )
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
     * @OA\Put(
     *      path="/articles/{articleId}",
     *      operationId="updateArticle",
     *      security={"api_key"},
     *      tags={"Articles"},
     *      summary="Update the article.",
     *      description="Update the article.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Article")
     *      ),
     *      @OA\Parameter(name="articleId", description="article id", in="path", required=true),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/Article"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest")
     *  )
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
     * @OA\Delete(
     *      path="/articles/{articleId}",
     *      operationId="deleteArticleById",
     *      security={"api_key"},
     *      tags={"Articles"},
     *      summary="Delete the article.",
     *      description="Delete the article.",
     *      @OA\Parameter(name="articleId", description="article id", in="path", required=true),
     *      @OA\Response(response=204, description="Deleted"),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest")
     *  )
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
