<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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


    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if($request->expectsJson()) {
          if ($exception instanceof \Illuminate\Auth\Access\authorizationException) {
            return response()->json([
              'Error' => 'Unauthorized',
            ], 401);
          }

          if ($exception instanceof Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
              'Error' => 'Not Found',
            ], 404);
          }

          if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $modelClass = explode('\\', $exception->getModel());

            return response()->json([
              'Error' => end($modelClass) . ' Not Found',
            ], 404);
          }
        }
        return parent::render($request, $exception);
    }
}
