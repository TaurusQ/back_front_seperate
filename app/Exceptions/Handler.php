<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTraits;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiResponseTraits;
    /**
     * A list of the exception types that are not reported.
     * 不需要记录到日志的异常
     * @var array
     */
    protected $dontReport = [
        InvalidRequestException::class,
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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if(env("APP_DEBUG")){
            return parent::render($request, $exception);
        }

        if($request->ajax()){
            if(!$exception instanceof ValidationException &&
                !$exception instanceof AuthenticationException 
               // !$exception instanceof NotFoundHttpException
            ){
                return $this->failed($exception->getMessage(),$exception->getCode());
            }
        }
        return parent::render($request, $exception);
    }
}
