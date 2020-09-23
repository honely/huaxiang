<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Comp extends Controller{

    /**
     * 添加房源对比
     * 1.用户 uid
     * 2.房源 hid
     * 3.房源类型 1 整租 ；2 合租
     */
    public function addToComp(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $hid = trim($this->request->param('hid'));
        $type = trim($this->request->param('type',1));
        if(!$uid || !$hid || !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['uid'] = $uid;
        $data['hid'] = $hid;
        $data['type'] = $type;
        $data['addtime'] = $uid;
        $insert = Db::table('tk_compare')->insertGetId($data);
        if($insert){
            $res['code'] = 1;
            $res['msg'] = '添加成功！';
            $res['h_id'] = $insert;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '添加失败！';
        return json($res);
    }


    /***
     *
     */
    public function myComp(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $type = trim($this->request->param('type',1));
        if(!$uid ||  !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['uid'] = $uid;
        $data['type'] = $type;
        $data['status'] = 1;
        $res = Db::table('tk_compare')->where($data)->field('id,hid')->select();
        if($res){
            foreach ($res as $k => $v){

            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $res;
            $res['count'] = sizeof($res);
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $res;
        $res['count'] = sizeof($res);
        return json($res);
    }


    public function compCount(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $type = trim($this->request->param('type',1));
        if(!$uid ||  !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['uid'] = $uid;
        $data['type'] = $type;
        $data['status'] = 1;
        $res = Db::table('tk_compare')->where($data)->count();
        if($res){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['count'] = $res;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['count'] = 0;
        return json($res);
    }
}