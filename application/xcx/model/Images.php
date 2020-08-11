<?php


namespace app\xcx\model;


use think\Image;
use think\Model;

class Images extends Model
{
    public function getComImage(){
        $imaUrl = 'http://www.huaxiang.com/uploads/text/20200731/242b397e5139476a4596e4f6601e43a3.jpg';
        $image = Image::open($imaUrl);
        $width = $image->width();
        $height = $image->height();
        $type = $image->type();
        $mime = $image->mime();
        $size = $image->size();
        dump($width);
        dump($height);
        dump($type);
        dump($mime);
        dump($size);
    }

}