<?php

namespace App\Observers;

use App\Handlers\FileUploadHandler;
use App\Models\Attachment;

class AttachmentObserver
{

    public function deleting(Attachment $attachment){
        app(FileUploadHandler::class)->deleteByStoragePath($attachment->storage_path);
    }
}
