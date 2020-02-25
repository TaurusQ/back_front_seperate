<?php
namespace App\Services;

use Illuminate\Support\Arr;

class MenuService{

    /**
     * 获取 格式化以后的 permission list
     * @param string $guard_name eg:admin
     * @return void
     * @Description
     * @example app(App\Services\MenuService::class)->getFormatterPermissionList("admin")
     * @author TaurusQ
     * @since
     * @date 2020-02-22
     */
    public function getFormatterPermissionList($guard_name){
        $config = config('permission_list');

        $data = [];
        $id = 1;

        foreach ($config as $k => $v){
            // 第一层（根目录）
            $parent = $this->fillMenuData(Arr::except($v,'child'),$id,$guard_name);
            
            array_push($data,$parent);
            $id++;

            // 如果permission有子项
            if(isset($v['child']) && count($v['child']) > 0){
                foreach ($v['child'] as $ke => $va){
                    // 第二层
                    $parent1 = $this->fillMenuData(Arr::except($va,'child'),$id,$guard_name,$parent);
                    
                    array_push($data,$parent1);
                    $id++;

                    if(isset($va['child']) && count($va['child']) > 0){
                        foreach ($va['child'] as $key => $val){
                            // 第三层
                            $parent2 = $this->fillMenuData(Arr::except($val,'child'),$id,$guard_name,$parent1);
                            array_push($data,$parent2);
                            $id++;

                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 填充permission List中没有的数据，主要是guard_name和pic
     *
     * @param [type] $arr
     * @param [type] $sort
     * @param [type] $guard_name
     * @param [type] $parent
     * @return void
     * @Description
     * @example
     * @author TaurusQ
     * @since
     * @date 2020-02-22
     */
    public function fillMenuData($arr,$sort,$guard_name,$parent = null){
        $arr['id'] = $sort;
        $arr['guard_name'] = $guard_name;

        // 判断 parent数据是否为空
        if(is_array($parent)){
            //$arr['level'] = $parent['level'] + 1;
            // $arr['path'] = $parent['path'].$parent['sort'].'-';
            $arr['pid'] = $parent['id'];
        }else{
            //$arr['level'] = 0;
            // $arr['path'] = '-';
        }

        // 检测路由是否存在
        if(array_key_exists('route_name',$arr) &&$arr['route_name']){
            $route = app('routes')->getByName($arr['route_name']);
            if(!$route) exit($arr["name"]." Route Name Valid");
        }

        /** 
        if(isset($arr['pid']) && isset($arr['route_name'])){
            // 获取路由Url
            // $route = app('routes')->getByName($arr['alias']);


        }
        */

        return $arr;
    }

    // 将 status map结构的数据转换成可以插入数据库中的格式
    // app(App\Services\MenuService::class)->getFormatterStatusMapList($data)
    public function getFormatterStatusMapList($data){

        $return = [];
        foreach($data as $key => $value){
            $temp['table_name'] = $key;
            
            foreach($value as $ke => $va){
                $temp['column'] = $ke;

                foreach($va as $k => $v ){
                    $temp['status_code'] = $k;
                    $temp['status_description'] = $v;

                    $return[] = $temp;
                }
            }
        }

        return $return;
    }
}