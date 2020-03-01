<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AdminsController extends AdminBaseController
{
    protected $createFillable = ["username","nickname", "password","status","description","remark"];
    protected $updateFillable = ["nickname","status","description","remark"];

    public function __construct(Admin $admin)
    {
        //parent::__construct();
        $this->model = $admin;
        parent::__construct();
    }

    public function list(Request $request)
    {
        $per_page = $request->get('limit', 10);
        return $this->getListData($per_page);
    }

    protected function storeRule()
    {
        return [
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|string|min:6',
            'remark' => 'string'
        ];
    }

    protected function updateRule($id)
    {
        return [
            'username' => 'string|unique:admins,username,' . $id,
            'password' => 'string',
            'remark' => 'string'
        ];
    }

    // 给admin分配角色
    public function assign(Request $request, Admin $admin)
    {
        $ids = $request->get("ids");
        $admin->syncRoles($ids);
        return $this->message("分配角色成功");
    }

    //重置密码
    public function reset(Request $request, $id)
    {
        // 重置之后的默认密码
        $data = ['password' => '123456'];
        if ($this->updateById($id, $data)) {
            return $this->message('密码重置为：' . $data['password']);
        } else {
            return $this->failed('数据重置失败');
        }
    }

    //修改密码
    /**
     * 测试用例：
     * $admin = \App\Models\Admin::find(3);
     * Hash::check('admin', $admin->password)
     */
    public function modify_password(Request $request)
    {
        // 旧密码，新密码，确认新密码
        $data = $request->only(['oldpassword', 'password', 'password_confirmation']);

        $validator = Validator::make(
            $data,
            [
                'oldpassword' => 'required|min:6',
                'password' => 'required|confirmed|min:6|different:oldpassword',
                'password_confirmation' => 'required|min:6'
            ],
            method_exists($this, 'ruleMessage') ? $this->ruleMessage() : []
        );

        //$user = Admin::findOrFail($id);
        $user = $this->guard()->user();
        $validator->after(function ($validator) use ($data, $user) {
            if (!Hash::check($data['oldpassword'], $user->password)) {
                $validator->errors()->add('oldpassword', '原始密码错误，请检查');
            }
        });

        if ($validator->fails()) {
            // 返回异常错误
            return $this->dealFailValidator($validator);
        }

        $data = Arr::only($data, ['password']);

        // if ($this->updateById($user->id, $data)) {
        if ($this->updateByModel($user, $data)) {
            return $this->message('密码修改成功');
        } else {
            return $this->failed('密码修改失败');
        }
    }
}
