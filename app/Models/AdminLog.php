<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLog extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }



    /*
    public function storeLog($input)
    {
        try {
            $this->fill($input);
            $this->user_id = $input['user_id'];
            $this->save();
            return $this->baseSucceed([], '操作成功');
        } catch (\Exception $e) {
            return $this->baseFailed('内部错误');
        }
    }

    const LOG_TYPE_LOGIN = 1; // 后台登录
    const LOG_TYPE_LOGOUT = 2;// 后台登出
    const LOG_TYPE_ACTION = 3; // 后台操作
    

    public static $logTypeMap = [
        self::LOG_TYPE_LOGIN => '后台登录',
        self::LOG_TYPE_LOGOUT => '后台登出',
        self::LOG_TYPE_ACTION => '后台操作',
    ];
    */
}
