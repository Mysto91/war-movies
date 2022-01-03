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
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
