<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => null);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            $map = [
                AuthenticationException::class => [401, 'Unauthenticated'],
                AuthorizationException::class => [403, 'Forbidden'],
                ModelNotFoundException::class => [404, 'Not Found'],
                NotFoundHttpException::class => [404, 'Route Not Found'],
                ValidationException::class => [422, 'Validation Error'],
            ];

            $status = 500;
            $message = 'Server Error';
            $result = null;

            foreach ($map as $class => [$code, $msg]) {
                if ($e instanceof $class) {
                    $status = $code;
                    $message = $msg;
                    if ($e instanceof ValidationException) {
                        $result = ['errors' => $e->errors()];
                    }
                    break;
                }
            }

            if ($status === 500) {
                \Log::error($e);

                if (config('app.debug')) {
                    $message = $e->getMessage();
                    $result = [
                        'exception' => get_class($e),
                        'trace' => collect($e->getTrace())->take(10),
                    ];
                }
            }

            return ApiResponse::error($message, $status, $result ? ['result' => $result] : []);
        });
    })
    ->create();
