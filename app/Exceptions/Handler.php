<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
                return $this->getResponse(405, 'The method is not allowed.', $e);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if ($request->is('api/articles/*')) {
                    return $this->getResponse(404, 'The article does not exist.', $e);
                }

                if ($request->is('api/users/*')) {
                    return $this->getResponse(404, 'The user does not exist.', $e);
                }

                return $this->getResponse(404, 'The ressource does not exist.', $e);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->getResponse(401, 'Unauthenticated.', $e);
        });

        $this->renderable(function (AccessDeniedHttpException  $e, $request) {
            return $this->getResponse(403, 'This action is unauthorized.', $e);
        });

        $this->renderable(function (ServiceUnavailableHttpException $e, $request) {
            return $this->getResponse(503, 'Unavailable Service.', $e);
        });

        $this->renderable(function (Exception $e, $request) {
            return $this->getResponse(500, 'Internal server error.', $e);
        });
    }

    /**
     * @param integer $httpCode
     * @param string $msg
     * @param Exception $exc
     *
     * @return JsonResponse
     */
    private function getResponse($httpCode, $msg, $exc): JsonResponse
    {
        Log::info($exc);
        return response()->json([$httpCode => $msg], $httpCode);
    }
}
