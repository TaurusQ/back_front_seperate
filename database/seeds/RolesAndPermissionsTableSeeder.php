<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 创建权限和角色时，需要带上 guard_name 参数，否则默认是 web

        // 先创建权限 name,guard_name,pid,type,route_name,description
        


         
        Permission::create(['name' => 'manage_contents', 'description' => '管理内容', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage_users', 'description' => '管理用户', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit_settings', 'description' => '数据添加修改', 'guard_name' => 'admin']);

        // 创建站长角色，并赋予权限
        $founder = Role::create(['name' => 'Founder', 'description' => '站长', 'guard_name' => 'admin']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => 'Maintainer', 'description' => '管理员', 'guard_name' => 'admin']);
        $maintainer->givePermissionTo('manage_contents');

        // 创建网站编辑角色，并赋予权限
        $maintainer = Role::create(['name' => 'WebsiteEditor', 'description' => '网站编辑', 'guard_name' => 'admin']);
        $maintainer->givePermissionTo('manage_contents');

        $maintainer = Role::create(['name' => 'Developer', 'description' => '开发人员', 'guard_name' => 'admin']);
        
    }
}
