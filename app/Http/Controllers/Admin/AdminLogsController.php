<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogsController extends AdminBaseController
{
    //public $fillable = [''];

    public function __construct(AdminLog $adminLog)
    {
        $this->model = $adminLog;
    }

    public function list(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        return $this->getListData($per_page);
    }
}
