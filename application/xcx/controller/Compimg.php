<?php


namespace app\xcx\controller;


use think\Controller;
use think\Db;
use think\Image;

class Compimg extends Controller
{
    public function gethouse(){
        $hid = $this->request->param('id');
        $HouseInfo = Db::table('tk_houses')->where(['id' => $hid])->find();
        $images = $HouseInfo['images'];
        if($images){
            $images = explode(',',$images);
            foreach ($images as $k => $item){
                $res = $this->formatImg($item);
                dump($res);
            }
        }
    }

    public function formatImg(){
        $file = "./uploads/admin/w.jpg";
        $size = filesize($file);
        $imgSize = ceil($size/1024);
        $Size1 = 1.5*1024;
        $Size2 = 2.5*1024;
        $Size3 = 3*1024;
        if($Size1 < $imgSize){
            return $file;
        }elseif($Size2 > $imgSize && $imgSize > $Size1){
            $this->compressImg($file,80);
        }elseif($Size3 > $imgSize && $imgSize > $Size2){
            $this->compressImg($file,70);
        }elseif($imgSize > $Size2){
            $this->compressImg($file,60);
        }else{
            $this->compressImg($file,40);
        }
        return $file;
    }

    /***
     * @param $filePath string 文件路径
     * @param $quality int 压缩比率
     * @return mixed
     */
    public function compressImg($filePath,$quality){
        $image = Image::open($filePath);
        $image->save("./uploads/admin/w1.jpg",null,$quality);
        return $filePath;
    }

}