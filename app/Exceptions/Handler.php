<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
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

        });
    }
}
