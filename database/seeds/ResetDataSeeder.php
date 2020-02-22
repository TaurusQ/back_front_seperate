<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
/**
 * 清除表数据
 */
class ResetDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('truncate table users');

        DB::select('SET FOREIGN_KEY_CHECKS=0');
        DB::select('truncate table roles');
        DB::select('truncate table model_has_roles');
        DB::select('truncate table role_has_permissions');
        DB::select('truncate table permissions');
        DB::select('truncate table model_has_permissions');
        DB::select('SET FOREIGN_KEY_CHECKS=1');

        DB::select('truncate table admins');
        /*
        DB::select('truncate table status_maps');
        DB::select('truncate table system_configs');
        DB::select('truncate table tables');
        */

        
        $tableNames = config('permission.table_names');
        
        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
        

        // 删除Migration 表中的permission相关数据
        DB::table('migrations')->where("migration","like","%permission%")->delete();

        // 手动调用 php artisan migrate
        // Illuminate\Support\Facades\Artisan::call('migrate')
        Artisan::call('migrate');
    }
}
