<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id')->default(0);
            //$table->string('table_name')->default('')->comment('表名');
            $table->string('url')->default('')->comment('操作URL');
            $table->text('data')->nullable()->comment('操作数据');
            $table->string('type')->default('insert')->comment('类型');
            $table->ipAddress('ip')->default('')->comment('IP');
            $table->string('address')->default('')->comment('地址');
            $table->string('ua')->default('')->comment('操作环境');
            $table->string('description')->default('')->comment('说明');
            $table->string('remark')->comment('备注');
            $table->softDeletes();
            $table->timestamps();

            $table->index('admin_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}
