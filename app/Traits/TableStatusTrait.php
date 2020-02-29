<?php
namespace App\Traits;
use Config;
use App\Models\StatusMap;

/**
 * 获取 table status 表中的相关配置
 *
 * @Description
 * @example
 * @author TaurusQ
 * @since
 * @date 2020-02-25
 */
trait TableStatusTrait
{
    public function getBaseStatus($table_name, $column = '')
    {
        $data = StatusMap::query()
            ->select('column', 'status_code', 'status_description')
            ->where('table_name', $table_name)
            ->get()
            ->groupBy('column')->map(function ($item) {
                return collect($item)->pluck('status_description', 'status_code');
            })->toArray();
        return $column && isset_and_not_empty($data,$column,'')?$data[$column]:$data; 
    }
}
