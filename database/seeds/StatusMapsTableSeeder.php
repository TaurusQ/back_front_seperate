<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/***
 * 单独执行Seeder： php artisan db:seed --class=StatusMapsTableSeeder
 */
class StatusMapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清空本表的数据
        DB::select('truncate table status_maps');

        $data = [

            // app notice 消息类型
            'app_notices' => [
                'type' => [
                    '1' => '系统消息',
                    '2' => '更新提示',
                    '3' => '警告通知',
                    '4' => '测试通知'
                ],
                'access_type' => [
                    'adm' => '所有管理员',
                    'usr' => '所有用户',
                    'pri' => '特定用户'
                ]
            ],

            'admins' => [
                'status' => [
                    '1' => '正常',
                    '-1' => '禁止'
                ]
            ],

            'users' => [
                'status' => [
                    '1' => '正常',
                    '-1' => '禁止'
                ]
            ],

            'admin_logs' => [
                'type' => [
                    '1' => '后台登录',
                    '2' => '后台登出',
                    '3' => '后台操作'
                ]
            ],

            'articles' => [
                'access_type' => [
                    'pub' => '公开访问',
                    'pri' => '私密访问',
                    'pwd' => '密码访问'
                ],
                'status' => [
                    '1' => '启用',
                    '-1' => '禁用'
                ]
            ]
        ];

        // 将数据转换格式
        // getFormatterData($data)

        DB::table('status_maps')->insert(app(App\Services\MenuService::class)->getFormatterStatusMapList($data));
    }
}
