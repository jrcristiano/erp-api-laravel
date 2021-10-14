<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
        'current_password',
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
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof FormRequestException) {
            return response()->json([
                'success' => false,
                'errors' => json_decode($e->getMessage())
            ], 400);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ], 404);
        }

        if ($e instanceof Exception) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ], 400);
        }
    }
}
