<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 系统通知
        Schema::create('app_notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->default(0)->comment('哪个管理员发的消息');
            $table->unsignedInteger('user_id')->default(0)->comment('发给哪个用户的消息,0为所有用户');
            $table->string('title')->default('');
            $table->string('content')->default('');
            $table->string('url')->default('')->comment('跳转url');
            $table->tinyInteger('type')->default(1)->comment('消息类型,系统消息，更新提示...');
            $table->boolean('is_alert')->default(false)->comment('是否弹窗显示');
            $table->boolean('is_open')->default(false)->comment('是否开放显示');
            $table->timestamp('read_at')->nullable()->comment('已读时间（仅针对单个用户）');
            $table->boolean('is_top')->default(false)->comment('是否置顶');
            $table->integer('weight')->default(20)->comment('权重');
            $table->enum('access_type',['usr','pri','adm'])->default('usr')->comment('访问权限类型：usr显示给所有用户，pri显示给单个用户，adm显示给所有管理员');
            $table->string('access_value')->default('')->comment('访问权限值');
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('is_alert');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_notices');
    }
}
