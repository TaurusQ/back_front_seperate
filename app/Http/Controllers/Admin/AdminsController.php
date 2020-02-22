<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminsController extends AdminBaseController
{
    public $fillable = ["username","password"];

    public function __construct(Admin $admin)
    {
        //parent::__construct();
        $this->model = $admin;
    }

    public function list(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        return $this->getListData($per_page);
    }

    protected function storeRule(){
        return [
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|string|min:6',
            'remark' => 'string'
        ];
    }

    protected function updateRule($id)
    {
        return [
            'username' => 'string|unique:admins,username,'.$id,
            'password' => 'string',
            'remark' => 'string'
        ];
    }

    public function assign(Request $request,Admin $admin){
        $ids = $request->get("ids");
        $admin->syncRoles($ids);
        return $this->message("分配角色成功");
    }
}
