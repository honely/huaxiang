<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Soup extends Controller
{
    public function getSoup(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $max = Db::table('xcx_soup')->max('id');
        $randid = mt_rand(1, $max);
        $soup = Db::table('xcx_soup')->where(['id' =>$randid])->field('id,content')->find();
        if($soup['content']){
            return $soup['content'];
        }else{
            return '别太晚睡，熬夜很伤手机的。';
        }
    }

}