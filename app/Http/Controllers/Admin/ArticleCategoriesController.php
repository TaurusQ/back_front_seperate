<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArticleCategoriesController extends AdminBaseController
{
    public $fillable = ['name', 'pid', 'is_open', 'weight', 'description'];

    public function __construct(ArticleCategory $articleCategory)
    {
        $this->model = $articleCategory;
    }

    protected function storeRule()
    {
        // bail属性：第一次验证失败后停止
        return [
            'name' => 'bail|required|between:2,100|unique:article_categories,name',
            'pid' => 'integer',
            'is_open' => 'required|boolean',
        ];
    }

    protected function updateRule($id)
    {
        return [
            'name' => 'bail|required|between:2,100|unique:article_categories,name,'.$id,
            'pid' => 'integer',
            'is_open' => 'required|boolean',
        ];
    }
}
