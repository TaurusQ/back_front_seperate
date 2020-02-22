<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

/**
 * php artisan make:controller Admin/PermissionsController
 *
 * @Description
 * @example
 * @author TaurusQ
 * @since
 * @date 2020-02-22
 */
class PermissionsController extends AdminBaseController
{
    protected $fillable = ['name', 'description', 'remark','guard_name','pid','type'];

    public function __construct(Permission $permission)
    {
        //parent::__construct();
        $this->model = $permission;
    }

    public function list(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        return $this->getListData($per_page);
    }

    protected function storeRule()
    {
        return [
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'required|string',
            'description' => 'string',
            'pid' => 'required|integer',
            'type' => 'required|in:1,2',
            'remark' => 'string'
        ];
    }

    protected function updateRule($id)
    {
        return [
            'name' => 'string|unique:permissions,name,'.$id,
            'pid' => 'integer',
            'type' => 'in:1,2',
            'remark' => 'string'
        ];
    }

    

    /** 
    public function show(Permission $permission){
        return $this->success($permission);
    }
    

    public function store(Request $request,Permission $permission){

    }
     */
}
