<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 系统消息
class AppNotice extends Model
{
    public $guarded = [];

    public $casts = [
        'is_alert' => 'boolean',
        'is_open' => 'boolean',
        'is_top' => 'boolean'
    ];

    public function admin(){
        return $this->belongsTo('App\Models\Admin');
    }

    /*
    type 由system config维护
    const TYPE_SYSTEM = 1;

    public static $typeMap = [
        self::TYPE_SYSTEM => '系统消息',
        
    ];
    

    const ACCESS_TYPE_ALL_ADMIN = "adm";
    const ACCESS_TYPE_ALL_USER = "usr";
    const ACCESS_TYPE_PRIVATE_USER = "pri";

    public static $accessTypeMap = [
        self::ACCESS_TYPE_ALL_ADMIN => '所有管理员',
        self::ACCESS_TYPE_ALL_USER => '所有用户',
        self::ACCESS_TYPE_PRIVATE_USER => '特定用户'
    ];
    protected $appends = ['access_type_text'];

    public function getAccessTypeTextAttribute(){
        return isset_and_not_empty(self::$accessTypeMap,$this->attributes['access_type'],'');
    }
    */
}
