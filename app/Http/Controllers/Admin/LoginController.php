<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidRequestException;
use App\Models\Admin;
use App\Services\AdminLogsService;
use App\Traits\ProxyTrait;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends AdminBaseController
{
    use AuthenticatesUsers, ProxyTrait;

    public function test()
    {
        //echo '123';
        //throw new InvalidRequestException("test error");
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        try {
            // 验证账号密码是否正确
            $user = Admin::query()->where($this->username(), $request->get($this->username()))->first();

            if (!$user) {
                //$this->response()->json("用户不存在", 401);
                return $this->failed("用户不存在", 401);
            }

            if (!Hash::check($request->get("password"), $user->password)) {
                //$this->response()->json("密码不正确", 401);
                app(AdminLogsService::class)->loginLogCreate($request, '密码不正确');
                return $this->failed("密码不正确", 401);
            }

            if ($user->status == Admin::STATUS_FORBIDEN) {
                app(AdminLogsService::class)->loginLogCreate($request, '该用户被禁用');
                return $this->failed("该用户被禁用", 401);
            }
           
            app(AdminLogsService::class)->loginLogCreate($request,'',$user);
            //$token = $user->createToken($this->token_name);
            //$token = $this->authenticate('admins');
            $token = $this->authenticate($this->provider_name);

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return $this->failed($e->getMessage());
        }
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
            app(AdminLogsService::class)->logoutLogCreate($request);
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
}
