<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ProxyTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    use AuthenticatesUsers, ProxyTrait;

    public $guard_name = "admin";
    public $provider_name = "admins";

    public function test()
    {

    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // 验证账号密码是否正确
        $user = Admin::query()->where($this->username(), $request->get($this->username()))->first();

        if (!$user) {
            $this->response()->json("用户不存在", 401);
        }

        if (!Hash::check($request->get("password"), $user->password)) {
            $this->response()->json("密码不正确", 401);
        }

        //$token = $user->createToken($this->token_name);

        //$token = $this->authenticate('admins');
        $token = $this->authenticate($this->provider_name);

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {
        return [
            "user" => $request->user(),
            "guard" => $this->guard()->user()
        ];
    }

    public function logout(Request $request)
    {
        if ($this->guard()->check()) {
            $this->guard()->user()->token()->delete();
            // print_r($this->guard()->user()->token());
        }
    }

    public function refresh(Request $request)
    {
        // print_r($request->all());exit;
        return $this->getRefreshToken($this->provider_name);
    }

    // 登录规则验证
    public function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            //'captcha' => 'required|captcha'
        ], [
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码'
        ]);
    }

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
