<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Corpapply extends Controller
{
    public function apply(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $email = trim($this->request->param('email'));
        $wechat = trim($this->request->param('wechat'));
        if(!$name || !$phone || !$email ||!$uid){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        //数据入
        $insert = Db::table('tk_corpapply')
            ->insertGetId([
                'corp_name' => $name,
                'phone' => $phone,
                'uid' => $uid,
                'email' => $email,
                'wechat' => $wechat,
                'ctime' => date('Y-m-d H:i:s')
            ]);
        if($insert){
            return json(['code'=>1,'msg'=>'发送成功！']);
        }else{
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }
    }


    public function houserent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $email = trim($this->request->param('email'));
        $wechat = trim($this->request->param('wechat'));
        $city = trim($this->request->param('city'));
        if(!$name || !$phone || !$email ||!$uid){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        //数据入
        $insert = Db::table('tk_houseapply')
            ->insertGetId([
                'ha_name' => $name,
                'ha_phone' => $phone,
                'ha_email' => $email,
                'ha_uid' => $uid,
                'ha_status' => 1,
                'ha_wechat' => $wechat,
                'ha_city' => $city,
                'ha_ctime' => date('Y-m-d H:i:s')
            ]);
        if($insert){
            return json(['code'=>1,'msg'=>'发送成功！']);
        }else{
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }
    }
}