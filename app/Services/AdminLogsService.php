<?php

namespace App\Services;

use App\Models\AdminLog;
use App\Traits\CurdTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Zhuzhichao\IpLocationZh\Ip;

class AdminLogsService
{

    use CurdTrait;

    protected $model = 'App\Models\AdminLog';

    public function __construct()
    {
        $this->admin = Auth::guard('admin')->user();
    }

    /**
     * 日志格式化
     * @param int $type
     * @param string $remark
     * @return array
     */
    public function getLogFormatter($type = 2, $description = '', $remark = '')
    {
        $ip = get_client_ip();
        return [
            'admin_id' => $this->admin->id ?? 0,
            'url' => request()->url(),
            'data' => http_build_query(request()->except('_token'), false),
            'type' => $type,
            'ip' => $ip,
            'address' => implode(' ', Ip::find($ip)),
            'ua' => request()->userAgent(),
            'description' => $description,
            'remark' => $remark
        ];
    }

    /**
     * 记录管理员登录日志
     * 因为使用的是 token 进行登录，所以在登录时无法获取 Auth::user
     * @param $request
     * @param string $err
     * @return mixed
     */
    public function loginLogCreate($request, $err = '',$admin = null)
    {
        if($admin) $this->admin = $admin;

        $description = $err
            ? " 登录失败，失败原因：{ $err }，登录的账号为：{$request->get('username')}　密码为：{$request->get('password')}"
            : "管理员: {$this->admin->username} 登录成功";

        $data = $this->getLogFormatter(AdminLog::LOG_TYPE_LOGIN, $description);

        return $this->add($data);
    }

    /**
     * 记录管理员注销日志
     * @param $request
     * @param string $remark 备注
     * @return mixed
     */
    public function logoutLogCreate($request, $remark = '')
    {
        $description = "管理员: {$this->admin->username} 注销账号";

        $data = $this->getLogFormatter(AdminLog::LOG_TYPE_LOGOUT, $description, $remark);

        return $this->add($data);
    }

    /**
     * 记录管理员操作日志
     * @param $request
     * @return bool
     */
    public function operateLogCreate()
    {
        $route = Route::currentRouteName();
        $permission = Permission::where('route_name')->first();

        if (!$permission) return false;

        if ($permission->pid) {
            $parent_permission = Permission::findById($permission->pid);
        }

        $description = "管理员: {$this->admin->username} 操作了 【" . $parent_permission->name . "】- 【{$permission->name}】 模块";

        $data = $this->getLogFormatter(AdminLog::LOG_TYPE_ACTION, $description); //dd($data);

        return $this->add($data);
    }
}
