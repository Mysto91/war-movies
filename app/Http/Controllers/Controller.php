<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Api Documentation",
     *      description="Implementation of Swagger with in Laravel",
     *      @OA\Contact(
     *          email="etiennetran@hotmail.fr"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     *
     * @OA\Response(
     *      response="NotFound",
     *      description="Resource not found.",
     *      @OA\JsonContent(
     *          @OA\Property(property="404", type="string", example="The article does not exist.")
     *      )
     * )
     *
     * @OA\Response(
     *      response="BadRequest",
     *      description="Bad request.",
     *      @OA\JsonContent(
     *          @OA\Property(property="400", type="string", example="Bad request.")
     *      )
     * )
     *
     * @OA\Response(
     *      response="Unauthorized",
     *      description="Unauthorized.",
     *      @OA\JsonContent(
     *          @OA\Property(property="401", type="string", example="Unauthenticated.")
     *      )
     * )
     *
     * @OA\Schema(
     *      schema="Links",
     *      @OA\Property(property="rel", type="string"),
     *      @OA\Property(property="type", type="string", enum={"GET"}),
     *      @OA\Property(property="href", type="string"),
     * )
     *
     */
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
