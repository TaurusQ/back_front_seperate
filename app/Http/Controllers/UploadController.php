<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Handlers\FileUploadHandler;
use App\Models\Attachment;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UploadController extends ApiController
{
    public function __construct()
    {
        //if(!request()->user()) throw new InvalidRequestException("请先登录");
        $this->middleware('multiauth:admin');
    }

    public function commonUpload($file_type,$category,Request $request,FileUploadHandler $fileuploadHandler){
        
        //print_r($request->all());exit;

        // 验证rule
        $validator = Validator::make($request->all(),[
            'file' => 'required|file'
        ]);

        if($validator->fails()){
            // 返回异常错误
            return $this->dealFailValidator($validator);
        }

        $file = $request->file('file');
        $data = $request->only("file","file_type");

        // 文件必须带有文件类型
        $file_name = explode('.', $file->getClientOriginalName());
        if (count($file_name) < 2) return $this->failed('无法识别文件类型', Response::HTTP_OK);

        $result = [];

        switch ($file_type){
            case Attachment::FILE_TYPE_PIC:
                $result = $fileuploadHandler->uploadImage($file,$category,$request->get("max_width",false));
            break;

            case Attachment::FILE_TYPE_FILE:
            break;

            case Attachment::FILE_TYPE_VIDEO:
            break;

            default:
            return $this->failed("错误的文件类型");
        break;
        }

        if ($result['status'] === true) {
            return $this->success($result['data']);
        } else {
            return $this->failed($result['message'], Response::HTTP_OK);
        }
    }

    public function testUpload(Request $request){
        
        $Authorization = $request->header("Authorization");

        $client = new Client();

        $token = "";

        try{
            $response = $client->request("POST","http://seperate.test/api/upload/pic/avatar",[
                "headers" => [
                    'authorization' => $Authorization,
                    //'X-Requested-With'=> 'XMLHttpRequest'
                ],
                "multipart" => [
                    [
                        "name" => "file",
                        "contents" => fopen(base_path()."/flat.png","r")
                    ]
                ]
            ]);
        }catch(Exception $e){
            //return $this->failed($e->getMessage());
            exit($e->getMessage());
        }

        echo $response->getBody();
        // print_r($response);
    }
}
