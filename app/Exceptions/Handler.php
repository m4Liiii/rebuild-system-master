<?php

namespace App\Exceptions;

use Throwable;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    if($exception instanceof NotFoundHttpException && $request->expectsJson())
    {
        return response()->json(['message' => 'Not Found!'], 404);
    }
    if ($exception instanceof UnauthorizedException) {
        return back()->with('error', 'You don\'t have permission to do this.');
    }
    if($exception instanceof NotFoundHttpException)
    {
        return redirect()->route('login');
    }


    return parent::render($request, $exception);
}
}
