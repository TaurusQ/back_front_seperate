<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ProxyTrait;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends UserBaseController
{
    use AuthenticatesUsers, ProxyTrait;

    public function login(Request $request)
    {

        // print_r($this->username());exit;
        $this->validateLogin($request);

        try {
            // 验证账号密码是否正确
            $user = User::query()->where($this->username(), $request->get($this->username()))->first();

            if (!$user) {
                return $this->failed("用户不存在", 401);
            }

            if (!Hash::check($request->get("password"), $user->password)) {
                return $this->failed("密码不正确", 401);
            }

            if ($user->status == User::STATUS_FORBIDEN) {
                return $this->failed("该用户被禁用", 401);
            }

            $token = $this->authenticate($this->provider_name);

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    public function refresh(Request $request)
    {
        return $this->getRefreshToken($this->provider_name);
    }

    public function me(Request $request)
    {
        return [
            "user" => $request->user(),
            "guard" => $this->guard()->user()
        ];
    }

    // 登录规则验证
    public function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
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
}
