<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return $this->getResponse(405, 'The method is not allowed.');
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if ($request->is('api/articles/*')) {
                    return $this->getResponse(404, 'The article does not exist.');
                }

                return $this->getResponse(404, 'The ressource does not exist.');
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->getResponse(401, 'Unauthenticated.');
        });

        $this->renderable(function (ServiceUnavailableHttpException $e, $request) {
            return $this->getResponse(503, 'Unavailable Service.');
        });

        $this->renderable(function (Exception $e, $request) {
            return $this->getResponse(500, 'Internal server error.');
        });
    }

    /**
     * @param integer $httpCode
     * @param string $msg
     *
     * @return JsonResponse
     */
    private function getResponse($httpCode, $msg): JsonResponse
    {
        return response()->json([$httpCode => $msg], $httpCode);
    }
}
