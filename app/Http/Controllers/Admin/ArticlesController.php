<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArticlesController extends AdminBaseController
{
    public $fillable = [
        // 'title', 'slug', 'keywords', 'description', 'cover_image', 'content', 'article_category_id',
         'status', 'is_recommend', 'is_top', 'weight', 'access_type', 'access_value'
    ];

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    protected function storeRule(){
        return [
            // 'title' => 'required|between:2,255',
            // 'article_category_id' => 'required|exists:article_categories,id',
            // 'content' => 'required',
            'slug' => 'string',
            'status' => ['required',Rule::in(array_keys(Article::$statusMap))],
            'is_recommend' => 'required|boolean',
            'is_top' => 'required|boolean',
            'weight' => 'required|integer',
            'access_type' => [
                'required','string',Rule::in(array_keys(Article::$accessTypeMap))
            ]
        ];
    }

    protected function updateRule($id)
    {
        return [
            // 'title' => 'required|between:2,255',
            // 'article_category_id' => 'required|exists:article_categories,id',
            // 'content' => 'required',
            'slug' => 'string',
            'status' => ['required',Rule::in(array_keys(Article::$statusMap))],
            'is_recommend' => 'required|boolean',
            'is_top' => 'required|boolean',
            'weight' => 'required|integer',
            'access_type' => [
                'required','string',Rule::in(array_keys(Article::$accessTypeMap))
            ]
        ];
    }

    protected function getAccessType()
    {
        return $this->success(Article::$accessTypeMap);
    }
}
