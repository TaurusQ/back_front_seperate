<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemConfig;
use Illuminate\Http\Request;

class SystemConfigsController extends AdminBaseController
{
    public $fillable = [
        'flag', 'title', 'config_group',
        'value', 'description', 'is_open'
    ];

    public function __construct(SystemConfig $systemConfig)
    {
        $this->model = $systemConfig;
    }

    protected function storeRule(){
        return [
            'flag' => [
                'bail',
                'regex:/^[a-z][a-zA-Z0-9_]{2,100}$/',
                'unique:system_configs'
            ],
            'title' => 'bail|between:2,100|unique:system_configs',
            'config_group' => 'required'
        ];
    }

    protected function updateRule($id){
        return [
            'flag' => [
                'bail',
                'regex:/^[a-z][a-zA-Z0-9_]{2,100}$/',
                'unique:system_configs,flag,'.$id
            ],
            'title' => 'bail|between:2,100|unique:system_configs,title,'.$id,
            'config_group' => 'required'
        ];
    }

    protected function ruleMessage(){
        return [
            'flag.regex' => '标识只能是2-100位的字母、数字、下划线组成',
            'flag.unique' => '标识已经存在',
            'title.between' => '配置标题只能在:min-:max个字符范围',
            'title.unique' => '配置标题已经被占用',
            'config_group.required' => '请选择配置分组'
        ];
    }
}
