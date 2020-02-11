<?php


namespace app\api\controller;


use think\Controller;

class Upload extends Controller
{


    /***
     * @return mixed
     * Created by Dangmengmeng At 2020/1/22 14:54
     */
    public function xcxUpload(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . '/upload/xcx');
            if($info){
                $res['name'] = $info->getFilename();
                $res['file'] = '/upload/xcx/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
            }
            return $res;
        }
    }
}