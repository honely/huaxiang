<?php


namespace app\xcx\controller;


use think\Controller;
use think\Image;

class Compimg extends Controller
{
    public function getComImage(){
        $file = '.\uploads\admin\123.jpg';
        $size = filesize($file);
        dump($size);
        //单位为KB
        $imgSize = ceil($size/(1024*1024));
        $compareSize = 1.5;
        if($imgSize > $compareSize){
            echo '当前图片大小'.$file.'Mb<br/><br/>';
            dump($file);
            $filew = $this->compressImg($file);
            $size1 = filesize($filew);
            //单位为KB
            $imgSize = ceil($size1/(1024*1024));
            echo '压缩后大小'.$imgSize;
        }else{
            echo '目标图片已小鱼1.5MB<br/><br/>';
            echo "目标图片大小".$imgSize."MB";
        }

    }


    /***
     * 压缩图片80%
     * @param $filePath
     */
    public function compressImg(){
        $filePath =".\uploads\admin\b.jpg";
        dump($filePath);
        $image = Image::open($filePath);
        dump($image);
        $res = $image->save('.\uploads\admin\b1.jpg');
        dump($res);
        return $filePath;
    }

}