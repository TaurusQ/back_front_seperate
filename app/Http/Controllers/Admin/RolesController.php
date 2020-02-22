<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends AdminBaseController
{
    public $fillable = ["name","guard_name","description","remark"];  
    public function __construct(Role $role)
    {
        //parent::__construct();
        $this->model = $role;
    }

    public function list(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        return $this->getListData($per_page);
    }

    protected function storeRule(){
        return [
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
            'description' => 'string',
            'remark' => 'string'
        ];
    }

    protected function updateRule($id)
    {
        return [
            'name' => 'string|unique:roles,name,'.$id,
            'guard_name' => 'string',
            'description' => 'string',
            'remark' => 'string'
        ];
    }

    /**
     * 分配角色的权限
     *
     * @param Request $request
     * @param Role $role
     * @return void
     * @Description
     * @example
     * @author TaurusQ
     * @since
     * @date 2020-02-22
     */
    public function assign(Request $request,Role $role){
        $ids = $request->get("ids");
        $role->syncPermissions($ids);
        return $this->message("分配权限成功");
    }
}
