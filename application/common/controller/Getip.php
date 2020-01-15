<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/28
 * Time: 14:47
 */
namespace app\common\controller;
use think\Controller;

class Getip extends Controller{
    public function index($ip){
        $ip = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
        $ip = json_decode($ip,true);
        return $ip;
    }
}