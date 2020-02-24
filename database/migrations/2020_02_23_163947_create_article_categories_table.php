<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('分类名称');
            $table->integer('pid')->default(0)->comment('上级 id');
            //$table->enum('enable', ['T', 'F'])->default('F')->comment('是否启用');
            $table->boolean('is_open')->default(false)->comment('是否启动');
            $table->integer('weight')->default(50);
            $table->string('description')->default('')->comment('描述');
            $table->timestamps();

            $table->index('pid');
            $table->index('weight');
            $table->index('is_open');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
