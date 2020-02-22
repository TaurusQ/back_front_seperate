<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * php artisan make:seeder UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(20)->make();
        User::insert($users->makeVisible(['password'])->toArray());

        // 单独处理第一个用户
        $user = User::find(1);
        $user->username = 'admin';
        //$user->status = '1';
        $user->save();
    }
}
