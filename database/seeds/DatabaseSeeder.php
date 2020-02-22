<?php

use Illuminate\Database\Seeder;

/**
 * php artisan db:seed 运行 DatabaseSeeder 类
 * php artisan migrate:refresh --seed
 * 
 * 单独执行Seeder： php artisan db:seed --class=UsersTableSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 将无关表中的数据清除
         * 如果直接运行 migrate:refresh --seed 会将所有表数据清除（包括oauth相关的表）
         * 会需要重新设置 passport 相关信息
         */
        $this->call(ResetDataSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(RolesAndPermissionsTableSeeder::class);
    }
}
