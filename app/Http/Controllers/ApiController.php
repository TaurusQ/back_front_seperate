<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Traits\ApiResponseTraits;
use App\Traits\CurdTrait;
use App\Traits\TableStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use ApiResponseTraits, CurdTrait, TableStatusTrait;

    protected $fillable = [];
    protected $createFillable = [];
    protected $updateFillable = [];
    protected $model;
    protected $resourceCollection = "App\Http\Resources\CommonCollection";

    protected function list(Request $request)
    {
        $per_page = $request->get('limit', 10);
        return $this->getListData($per_page);
    }

    // limit 参数表示每页多少条数据
    protected function getListData($pageSize)
    {
        $data = $this->model->where($this->convertWhere(request()->all()))->paginate($pageSize);
        return new $this->resourceCollection($data);
    }

    protected function show($id)
    {
        // $data = $this->model::findOrFail($id);
        $data = $this->find($id);

        if(!$data) throw new InvalidRequestException("数据不存在");

        return $this->success($data);
    }

    protected function store(Request $request)
    {
        // 1. 获取前端数据
        $data = $request->only($this->createFillable ?? $this->fillable);

        //  2. 验证数据
        /*
        if (method_exists($this, 'ruleMessage')) {
            $validator = Validator::make($data, $this->storeRule(), $this->ruleMessage());
        } else {
            $validator = Validator::make($data, $this->storeRule());
        }
        */
        
        $this->validateRequest(
            $request,
            $this->storeRule(),
            method_exists($this, 'ruleMessage') ? $this->ruleMessage() : []
        );

        /*
        $validator = Validator::make(
            $data,
            $this->storeRule(),
            method_exists($this, 'ruleMessage') ? $this->ruleMessage() : []
        );

        if ($validator->fails()) {
            // 返回异常错误
            return $this->dealFailValidator($validator);
        }
        */

        // 3.数据无误，进一步处理后保存到数据表里面，有的表需要处理，有的不需要
        $data = $this->storeHandle($data);

        // if ($this->model::create($data)) {
        if ($res = $this->add($data)) {
            //return $this->messageWithCode('新增数据成功', 201);
            return $this->successWithCode($res,'新增数据成功',201);
        } else {
            return $this->failed('新增数据失败');
        }
    }

    protected function update(Request $request, $id)
    {
        // 1. 获取前端数据
        $data = $request->only($this->updateFillable ?? $this->fillable);

        //  2. 验证数据
        $this->validateRequest(
            $request,
            $this->updateRule($id),
            method_exists($this, 'ruleMessage') ? $this->ruleMessage() : []
        );

        /*
        if (method_exists($this, 'message')) {
            $validator = Validator::make($data, $this->updateRule($id), $this->ruleMessage());
        } else {
            $validator = Validator::make($data, $this->updateRule($id));
        }

        if ($validator->fails()) {
            // 返回异常错误
            return $this->dealFailValidator($validator);
        }
        */
        // 进一步处理数据
        $data = $this->updateHandle($data);

        // 更新到数据表
        //if ($this->model::where('id', $id)->update($data)) {
        if ($res = $this->updateById($id, $data)) {
            return $this->message('数据更新成功');
            // return $this->success($res,'数据更新成功');
        } else {
            return $this->failed('数据更新失败');
        }
    }

    public function destroy($id)
    {
        if ($this->destoryHandle($id)) {
            // $this->log('delete', Route::currentRouteName(), '删除信息');
            return  $this->messageWithCode('数据删除成功', 200);
        } else {
            return $this->failed('数据删除失败，请查看指定的数据是否存在');
        }
    }

    protected function destoryHandle($id)
    {
        DB::transaction(function () use ($id) {
            // 删除逻辑  注意多表关联的情况
            /*
            if (is_array($id)) {
                $this->model::whereIn('id', $id)->delete();
            } else {
                $this->model::where('id', $id)->delete();
            }
            */
            //$this->model->destroy($id);
            $this->delete($id);
        });
        return true;
    }

    /**
     * 批量删除
     *
     * @return void
     * @Description
     * @example
     * @author TaurusQ
     * @since
     * @date 2020-02-22
     */
    public function deleteAll()
    {
        // 前端利用json格式传递数据
        $ids = request()->input('ids');
        $this->destoryHandle($ids);
        // $this->log('delete', Route::currentRouteName(), '删除多条信息');
        return $this->messageWithCode('批量删除数据成功', 200);
    }

    protected function dealFailValidator($validator)
    {
        // 有错误，处理错误信息并且返回
        $errors = $validator->errors();
        $errorTips = '';
        foreach ($errors->all() as $message) {
            $errorTips = $errorTips . $message . ',';
        }
        $errorTips = substr($errorTips, 0, strlen($errorTips) - 1);
        //return $this->failed($errorTips, 422);
        throw new InvalidRequestException($errorTips,422);
    }

    /**
     * 进行表单验证
     *
     * @param Request $request
     * @param [type] $validateRules 验证规则
     * @param [type] $ruleMessages 验证返回信息
     * @author TaurusQ
     * @since
     * @date 2020-03-02
     */
    protected function validateRequest(Request $request,$validateRules,$ruleMessages = []){
        $validator = Validator::make($request->all(),$validateRules,$ruleMessages);
        if($validator->fails()){
            $this->dealFailValidator($validator);
        }
    }

    protected function storeHandle($data)
    {
        return $data;   // TODO: Change the autogenerated stub
    }

    protected function updateHandle($data)
    {
        return $data;
    }

    // https://learnku.com/docs/laravel/6.x/validation/5144
    protected function storeRule()
    {
        return [];
    }

    protected  function updateRule($id)
    {
        return [];
    }

    /**
     * 验证返回的规则信息
     *
     * @return void
     * @Description
     * @example
     * @author TaurusQ
     * @since
     * @date 2020-02-22
     */
    protected function  ruleMessage()
    {
        return [];
    }

    /**
     * 自定义登录看守器
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard_name ?? '');
    }
}
