<?php

namespace App\Exceptions;

use App\Concerns\Restable;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use Restable;

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
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $this->setStatusCode(Response::HTTP_NOT_FOUND);
            return $this->respond(['data' => null]);
        }

        if ($exception instanceof NotFoundHttpException) {
            $this->setStatusCode(Response::HTTP_NOT_FOUND);
            return $this->respond(['data' => 'Route is not found.']);
        }

        if ($exception instanceof FileIsTooBig) {
            $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            return $this->respond([
                'message' => '',
                'errors' => [
                    'files' => $exception->getMessage()
                ]
            ]);
        }

        return parent::render($request, $exception);
    }
}
