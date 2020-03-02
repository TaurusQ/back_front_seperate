<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [];

    const FILE_TYPE_PIC = "pic";
    const FILE_TYPE_FILE = "file";
    const FILE_TYPE_VIDEO = "video";
}
