<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_name')->default('')->comment('表名称');
            $table->string('column')->default('')->comment('字段名称');
            $table->string('status_code')->default('')->comment('状态码');
            $table->string('status_description')->default('')->comment('状态码说明');
            $table->string('remark')->default('')->comment('备注');
            $table->softDeletes();
            $table->timestamps();

            $table->index('table_name');
            $table->index('column');
            $table->index('status_code');
            $table->index('status_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_maps');
    }
}
