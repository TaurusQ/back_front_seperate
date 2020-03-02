<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentsController extends AdminBaseController
{
    // 不允许手动创建和修改
    protected $createFillable = ["remark"];
    protected $updateFillable = ["remark"];

    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
        parent::__construct();
    }

    public function list(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        return $this->getListData($per_page);
    }

    protected function updateRule($id)
    {
        return [
            'remark' => 'string'
        ];
    }

    // 进行删除操作时，将原始文件进行删除，这部分操作在Observer中
}
