<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppNotice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppNoticeController extends AdminBaseController
{
    public $fillable = ["admin_id", "user_id", "title", "content", "url", 
        "type", "is_alert","is_open", "read_at","is_top","weight","access_type","access_value"];

    public function __construct(AppNotice $appNotice)
    {
        //parent::__construct();
        $this->model = $appNotice;
    }

    protected function storeRule()
    {
        return [
            //'admin_id' => 'required|string|unique:admins,username',
            'title' => 'required|string|min:6',
            'content' => 'required|string|min:6',
            'url' => 'url',
            'type' => [
                'required','integer',
                //Rule::in(array_keys(AppNotice::$typeMap))
            ],
            'is_alert' => 'boolean',
            'is_open' => 'boolean',
            'is_top' => 'boolean',
            'weight' => 'integer',
            'access_type' => [
                'required','string',Rule::in(array_keys(AppNotice::$accessTypeMap))
            ]
        ];
    }

    protected function storeHandle($data)
    {
        $data['admin_id'] = $this->guard()->user()->id;
        return $data;
    }

    protected function updateRule($id)
    {
        return [
            'title' => 'required|string|min:6',
            'content' => 'required|string|min:6',
            'type' => ['required','integer'],
            'is_alert' => 'boolean',
            'is_alert' => 'boolean',
            'is_open' => 'boolean',
            'is_top' => 'boolean',
            'weight' => 'integer',
            'access_type' => [
                'required','string',Rule::in(array_keys(AppNotice::$accessTypeMap))
            ]
        ];
    }

    protected function getAccessType()
    {
        return $this->success(AppNotice::$accessTypeMap);
    }
}
