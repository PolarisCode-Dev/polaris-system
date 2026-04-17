<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        //
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        if (! $request->expectsJson()) {
            return $response;
        }

        $status = $response->getStatusCode();
        $message = Response::$statusTexts[$status] ?? 'HTTP error';
        $data = null;

        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $message = 'Resource not found';
        } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            $message = 'Validation failed';
            $data = $exception->errors();
        } elseif ($response instanceof JsonResponse) {
            $payload = $response->getData(true);

            if (is_array($payload)) {
                if (isset($payload['message']) && is_string($payload['message']) && $payload['message'] !== '') {
                    $message = $payload['message'];
                }

                if (array_key_exists('errors', $payload)) {
                    $data = $payload['errors'];
                } elseif (array_key_exists('data', $payload)) {
                    $data = $payload['data'];
                }
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status, $response->headers->all());
    }
}
