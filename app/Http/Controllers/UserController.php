<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\PostUserRequest;
use App\Http\Requests\User\PutUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getAllUsers",
     *      security={"api_key"},
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Get all users.",
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/User")
     *              )
     *          )
     *      ),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *      @OA\Response(response="401", ref="#/components/responses/Unauthorized"),
     *  )
     *
     * @param GetUserRequest $request
     *
     * @return JsonResponse
     */
    public function index(GetUserRequest $request): JsonResponse
    {
        $userList = User::getUserList($request->validated());

        return UserResource::collection($userList)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Create a user",
     *      description="Create a user.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/User"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *  )
     *
     *
     * @param  PostUserRequest  $request
     * @return JsonResponse
     */
    public function store(PostUserRequest $request): JsonResponse
    {
        $params = $request->validated();

        $user = User::create(
            [
                'name' => $params['name'],
                'email' => $params['email'],
                'password' => $params['password'],
                'api_token' => bcrypt($params['name'])
            ]
        );

        return UserResource::make($user)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *      path="/users/{userId}",
     *      operationId="getUserById",
     *      security={"api_key"},
     *      tags={"Users"},
     *      summary="Get the user",
     *      description="Get the user.",
     *      @OA\Parameter(name="userId", description="user id", in="path", required=true),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/User"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *      @OA\Response(response="401", ref="#/components/responses/Unauthorized"),
     * )
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return UserResource::make($user)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * @OA\Put(
     *      path="/users/{userId}",
     *      operationId="updateUser",
     *      security={"api_key"},
     *      tags={"Users"},
     *      summary="Update a user",
     *      description="Update a user.",
     *      @OA\Parameter(name="userId", description="user id", in="path", required=true),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/User"
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *      @OA\Response(response="401", ref="#/components/responses/Unauthorized"),
     *  )
     *
     * @param  PutUserRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(PutUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return UserResource::make($user)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Delete(
     *      path="/users/{userId}",
     *      operationId="deleteUserById",
     *      security={"api_key"},
     *      tags={"Users"},
     *      summary="Delete the user.",
     *      description="Delete the user.",
     *      @OA\Parameter(name="userId", description="user id", in="path", required=true),
     *      @OA\Response(response=204, description="Deleted"),
     *      @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *      @OA\Response(response="400", ref="#/components/responses/BadRequest"),
     *      @OA\Response(response="401", ref="#/components/responses/Unauthorized"),
     *  )
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response([], 204);
    }
}
