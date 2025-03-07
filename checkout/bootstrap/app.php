<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (BadRequestHttpException $e, Request $request) {
            if ($request->is('*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }

            return $request->expectsJson();
        });
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }

            return $request->expectsJson();
        });
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('*')) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }

            return $request->expectsJson();
        });
    })->create();
