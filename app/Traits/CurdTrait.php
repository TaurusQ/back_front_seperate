<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait CurdTrait
{
    public function add(array $input)
    { //dd($input);
        $model = $this->model;

        return $model::create($input);
    }

    public function saveById($id, array $data)
    {
        $item = self::find($id);

        foreach ($data as $key => $value) {
            $item->$key = $value;
        }

        return $item->save();
    }

    public function find($id, array $columns = ['*'])
    {
        $model = $this->model;

        return $model::find($id, $columns);
    }


    public function updateById($id, array $input)
    {
        $model = $this->model->findOrFail($id);

        return $this->updateByModel($model, $input);
        //return $model::where('id', $id)->update($input);
    }

    public function updateByModel($model, $input)
    {
        $model->fill($input);

        return $model->save($input);
    }


    public function all(array $columns = ['*'])
    {
        $model = $this->model;

        return $model::all($columns);
    }

    /*
    public function get()
    {
        $model = $this->model;

        if (property_exists($model, 'order')) {
            return $model::orderBy($model::$order, $model::$sort)->get($model::$index);
        }

        return $model::get($model::$index);
    }
    */

    public function getCount()
    {
        $model = $this->model;

        return $model::where('id', '>=', 1)->count();
    }

    public function getLatestPaginate($limit, array $columns = ['*'])
    {
        $model = $this->model;

        return $model::orderBy('updated_at', 'desc')->paginate($limit, $columns);
    }

    public function getByWhere(array $where, $columns = ['*'])
    {
        $model = $this->model;

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $model = $model->where($field, $condition, $val);
            } else {
                $model = $model->where($field, '=', $value);
            }
        }

        if (property_exists($model, 'sort')) {
            $model = $model::orderBy('sort', 'asc');
        }

        return $model->get($columns);
    }

    public function getByWhereIn($field, array $value, $columns = ['*'])
    {
        $model = $this->model;

        return $model->whereIn($field, $value)->get($columns);
    }

    public function getByWhereNotIn($field, array $value, $columns = ['*'])
    {
        $model = $this->model;

        return $model->whereIn($field, $value)->get($columns);
    }

    public function paginateWhere($where, $limit = 10, $columns = ['*'])
    {
        $model = $this->model;

        if (!empty($where)) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    list($field, $condition, $val) = $value;
                    if (in_array($condition, ['in', 'between'])) {
                        $condition = 'where' . ucfirst($condition);
                        $model = $model->$condition($field, $val);
                    } else {
                        $model = $model->where($field, $condition, $val);
                    }
                } else {
                    if (!in_array($value, ['page', 'limit'])) {
                        //'name' => 'admin'
                        $model = $model->where($field, '=', $value);
                        //$model = $model->where($field,'like','%'.$value.'%');
                    }
                }
            }
        }
        //dd($model);
        return $model->paginate($limit, $columns, 'page', request()->get('page'));
    }

    public function convertWhere($where)
    {
        $condition = [];
        if (!empty($where)) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    list($field, $condition, $val) = $value;
                } else {

                    // 参数以_at结尾，并且值中有“~”表示日期搜索
                    if (Str::endsWith($field, '_at') && Str::contains($value, '~')) {
                        list($start_at, $ends_at) = explode('~', $value);
                        array_push($condition, [$field, '>', $start_at]);
                        array_push($condition, [$field, '<', $ends_at]);
                    } else if (!in_array($field, ['page', 'limit']) && isset($value)) array_push($condition, [$field, 'like', '%' . $value . '%']);
                }
            }
        } //dd($condition);
        return $condition;
    }

    public function lists($value, $key)
    {
        $model = $this->model;

        return $model->pluck($value, $key);
    }

    public function delete($id)
    {
        $model = $this->model;

        return $model::destroy($id);
    }
}
