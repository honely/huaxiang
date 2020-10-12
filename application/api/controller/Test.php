<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Test extends Controller
{
    public function index(){
        $res = Db::table('text')->group('name')->limit(3)->select();
        dump($res);
    }

}