<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique()->comment('用户名');
            $table->string('password');
            $table->string('realname')->nullable()->comment('真实姓名');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('email')->unique()->comment('电子邮箱');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('mobile')->unique()->nullable()->comment('手机号码');
            $table->string('description')->default('')->comment('一句话描述');
            $table->string('remark')->default('')->comment('备注');
            $table->tinyInteger('status')->default(1)->comment('状态1启用-1禁用');
            //$table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('mobile');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
