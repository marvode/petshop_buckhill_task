<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
            //
        });
    }

    public function render($request, Throwable $exception): Response
    {
        if (!$request->is('api/*'))
            return parent::render($request, $exception);

        if ($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception, $request);

        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse([$modelName . ' does not exist with the specified id'], 404);
        }

        if ($exception instanceof AuthenticationException)
            return $this->unauthenticated($request, $exception);

        if ($exception instanceof AuthorizationException)
            return $this->errorResponse([$exception->getMessage()], 403);

        if ($exception instanceof NotFoundHttpException)
            return $this->errorResponse(['The specified URL cannot be found'], 404);

        if ($exception instanceof MethodNotAllowedException)
            return $this->errorResponse(['The specified method for the request is invalid'], 405);

        if ($exception instanceof HttpException)
            return $this->errorResponse([$exception->getMessage()], $exception->getStatusCode());

        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1451) {
                return $this->errorResponse(['Cannot remove this resource permanently. It is related with other resources'], 409);
            }
        }

        return parent::render($request, $exception);
    }

    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $request->is('api/*');
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse|Response
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception): Response
    {
        $message = $exception->getMessage() ?? 'Unauthenticated';
        return $this->errorResponse([$message], 401);
    }
}
