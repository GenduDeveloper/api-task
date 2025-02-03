<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Пользователь не аутентифицирован'
            ], 401);
        }

        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'message' => 'Нет доступа'
            ], 403);
        }

        return $next($request);
    }
}
