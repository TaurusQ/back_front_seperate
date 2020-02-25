<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $guarded = [];

    public $casts = [
        'is_recommend' => 'boolean',
        'is_top' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /*
    const ACCESS_TYPE_PUBLIC = "pub";
    const ACCESS_TYPE_PRIVATE = "pri";
    const ACCESS_TYPE_PASSWORD = "pwd";

    public static $accessTypeMap = [
        self::ACCESS_TYPE_PUBLIC => '公开访问',
        self::ACCESS_TYPE_PRIVATE => '私密访问',
        self::ACCESS_TYPE_PASSWORD => '密码访问'
    ];

    const STATUS_ALLOW = '1';
    const STATUS_FORBIDEN = '-1';

    public static $statusMap = [
        self::STATUS_ALLOW => '启用',
        self::STATUS_FORBIDEN => '禁用',
    ];

    protected $appends = ['access_type_text','status_text'];

    public function getAccessTypeTextAttribute(){
        return isset_and_not_empty(self::$accessTypeMap,$this->attributes['access_type'],'');
    }

    public function getStatusTextAttribute(){
        return isset_and_not_empty(self::$statusMap,$this->attribute['status'],'');
    }
    */
}
