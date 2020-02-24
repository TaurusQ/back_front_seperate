<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    public $guarded = [];

    public $casts = [
        'is_open' => 'boolean'
    ];
}
