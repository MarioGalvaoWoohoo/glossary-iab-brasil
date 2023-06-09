<?php

namespace App\Exceptions;

use App\Repository\Exceptions\NotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use App\Exceptions\CustomException;
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (CustomException $e, $request) {
            return response()->json([
                'error' => $e->getData(),
                'message' => $e->getMessage()
            ], $e->getCode());
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundException) {
            return response()->json(
                ['errors' => $exception->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }

        return parent::render($request, $exception);
    }
}
