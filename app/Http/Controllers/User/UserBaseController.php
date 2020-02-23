<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


/**
 * 前台Base控制器，这里写后台部分独有的功能
 *
 * @Description
 * @example
 * @author TaurusQ
 * @since
 * @date 2020-02-22
 */
class UserBaseController extends ApiController
{
    public $guard_name = "user";
    public $provider_name = "users";

    /**
     * 自定义登录参数
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
