<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    public $guarded = [];

    public $cast = [
        'is_open' => 'boolean'
    ];
}
