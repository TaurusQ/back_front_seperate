<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 后台Base控制器，这里写后台部分独有的功能
 *
 * @Description
 * @example
 * @author TaurusQ
 * @since
 * @date 2020-02-22
 */
class AdminBaseController extends ApiController
{
    public $guard_name = "admin";
    public $provider_name = "admins";

    /**
     * 自定义登录参数
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * 自定义登录看守器
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard_name);
    }
}
