<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTraits;
/**
 * 用户错误行为触发的异常
 * Class InvalidRequestException
 * @package App\Exceptions
 */
class InvalidRequestException extends Exception
{
    use ApiResponseTraits;

    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }

    /**
     * Laravel 5.5 之后支持在异常类中定义 render() 方法，该异常被触发时系统会调用 render() 方法来输出
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            // json() 方法第二个参数就是 Http 返回码
            //return response()->json(['msg' => $this->message], $this->code);
            return $this->failed($this->message,$this->code);
        }
        return view('pages.error', ['msg' => $this->message,'code' => $this->code]);
    }
}
