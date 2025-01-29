<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $this->renderHttpException($exception);
        }
    
        return parent::render($request, $exception);
    }
    
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        $status = $e->getStatusCode();
    
        if ($status == 404) {
            return response()->view('errors.404', [], $status);
        } elseif ($status == 403) {
            return response()->view('errors.403', [], $status);
        }
    
        return parent::renderHttpException($e);
    }
}
