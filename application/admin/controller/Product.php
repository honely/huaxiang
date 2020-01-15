<?php
namespace app\admin\controller;
use think\Controller;

class Product extends Controller{


    /***
     * Name: 商品列表方法
     * @return mixed
     * Created by DangMengmeng at 2019/9/6 15:25
     */
    public function index(){
        return '商品列表';
    }


    /***
     * Name: 添加商品方法
     * Created by DangMengmeng at 2019/9/6 15:29
     */
    public function addPro(){
        return '添加商品';
    }
}
