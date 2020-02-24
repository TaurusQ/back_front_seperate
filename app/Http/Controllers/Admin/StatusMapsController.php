<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusMap;
use Illuminate\Http\Request;

class StatusMapsController extends AdminBaseController
{
    public $fillable = [
        'table_name', 'column', 'status_code',
        'status_description', 'remark'
    ];

    public function __construct(StatusMap $statusMap)
    {
        $this->model = $statusMap;
    }

    protected function storeRule()
    {
        return [
            'table_name' => 'required',
            'column' => 'required|between:1,255|alpha_dash',
            // alpha_dash:验证字段可能包含字母、数字，以及破折号 (-) 和下划线 ( _ )
            'status_code' => 'required|between:1,255|alpha_dash',
            'status_description' => 'required|between:1,255'
        ];    
    }

    protected function updateRule($id)
    {
        return [
            'table_name' => 'required',
            'column' => 'required|between:1,255|alpha_dash',
            // alpha_dash:验证字段可能包含字母、数字，以及破折号 (-) 和下划线 ( _ )
            'status_code' => 'required|between:1,255|alpha_dash',
            'status_description' => 'required|between:1,255'
        ]; 
    }


}
