<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

/**
 * php artisan make:seeder AdminsTableSeeder
 */
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        $admin = factory(Admin::class)->times(3)->make();

        // 让隐藏字段可见，并将数据集合转换为数组
        Admin::insert($admin->makeVisible(['password'])->makeHidden(['status_text'])->toArray());

        // 处理第一个用户，密码默认都是 admin
        $admin = Admin::find(1);
        $admin->username = 'admin';
        $admin->save();

        // 分配角色：站长，开发者
        $admin->assignRole('Founder', "Developer");

        // 处理第二个用户
        $admin = Admin::find(2);
        $admin->username = 'user2';
        $admin->save();

        // 分配角色：网站编辑
        $admin->assignRole('WebsiteEditor');
    }
}
