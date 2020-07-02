<?php


namespace app\xcx\controller;


use think\console\command\make\Controller;

class Text extends Controller
{
    public function index(){
        date_default_timezone_set("Australia/Melbourne");
        $date = '2020-07-02 16:07:39';
        $time = date('Y-m-d H:i:s');
        $new = date('Y-m-d H:i:s', strtotime($date.' +30 minutes'));
        dump('old'.$date);
        dump('new'.$new);
        dump('now'.$time);
        if($new < $time){
            echo '更新时间已经超过30分钟';
        }else{
            echo '未超过30分钟';
        }
    }

}