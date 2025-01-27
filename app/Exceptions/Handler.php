<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

            // $this->reportable()

            $this->renderable(function (UserNotFoundException|ModelNotFoundException $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 404);
            });

            $this->renderable(function (RegisterErrorException $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            });

            $this->renderable(function (AuthenticationException $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 422);
            });

        });
    }
}
