<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Hello extends Controller
{
    public function index(){
        $data = Db::connect('db2')->table()->where()->select();
        dump($data);
    }

}