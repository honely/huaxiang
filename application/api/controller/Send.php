<?php


namespace app\api\controller;


use app\xcx\model\Msgs;
use think\Controller;
use think\Db;
use think\Loader;

class Send extends Controller
{
    /**
     *发送短信验证码
     */
    public function sendSms(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        if($phone == ''){
            return  json(['code' => '0','msg' => '手机号不能为空！']);
        }
        $myreg = "/^(\+?0?86\-?)?1[345789]\d{9}$/";
        $au = "/^(\+?61|0)4\d{8}$/";
        //匹配国内手机号成功返回1 失败返回0
        $res = preg_match($myreg,$phone);
        //匹配澳洲手机号，成功返回1 失败返回0
        $resAu = preg_match($au,$phone);
        //判断手机号是否正确
        //判断是否为澳洲手机号
        $code = mt_rand(999, 9999);
        if($res){
            //短信预发送
            $rens['msg_type'] = 3;
            $rens['send_time'] = date('Y-m-d');
            $rens['send_datetime'] = date('Y-m-d H:i:s');
            $rens['phone'] = $phone;
            $rens['remarks'] = '发布房源短信验证码（'.$code.'）。';
            $rens['status'] = 0;
            $rens['codes'] = $code;
            $rens['country'] = 'Cn';
            $insertId = Db::connect('db3')->table('super_msg_send')->insertGetId($rens);
            Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1=$sems->sendSms1($phone,$code);
            $array=$this->object2array($sem1);
            $data['code'] = $code;
            $data['phone'] = $phone;
            if($array['Code'] == 'OK'){
                //短信发送成功，更新发送状态
                Db::connect('db3')->table('super_msg_send')->where(['id' => $insertId])->update(['status' =>1,'remarks' => $rens['remarks'].';消息已发送。']);
                return  json(['code' => '1','msg' => '国内短信发送成功！','data' =>$code]);
            }else{
                Db::connect('db3')->table('super_msg_send')->where(['id' => $insertId])->update(['status' =>2,'remarks' => $rens['remarks'].';消息发送失败。']);
                return  json(['code' => '0','msg' => '短信发送失败！']);
            }
        }
        if($resAu){
            //短信预发送
            $rens['msg_type'] = 3;
            $rens['send_time'] = date('Y-m-d');
            $rens['send_datetime'] = date('Y-m-d H:i:s');
            $rens['phone'] = $phone;
            $rens['remarks'] = '发布房源短信验证码'.$code.'。';
            $rens['status'] = 0;
            $rens['codes'] = $code;
            $rens['country'] = 'Au';
            $insertId = Db::table('super_msg_send')->insertGetId($rens);
            $msg = new Msgs();
            $res = $msg->sendAus($code,$phone);
            if($res == 200){
                //短信发送成功，更新发送状态
                Db::connect('db3')->table('super_msg_send')->where(['id' => $insertId])->update(['status' =>1,'remarks' => $rens['remarks'].';消息已发送。']);
                return  json(['code' => '1','msg' => '澳洲短信发送成功！','data' =>$code]);
            }else{
                //短信发送成功，更新发送状态
                Db::connect('db3')->table('super_msg_send')->where(['id' => $insertId])->update(['status' =>2,'remarks' => $rens['remarks'].';消息发送失败。']);
                return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
            }
        }
    }


    public function varify(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        $codes = trim($this->request->param('codes'));
        if(!$phone){
            return json(['code'=>0,'msg'=>'手机号为空！']);
        }
        if(!$codes){
            return json(['code'=>0,'msg'=>'验证码为空！']);
        }
        $inserts = Db::connect('db3')
            ->table('super_msg_send')
            ->where(['phone' => $phone,'msg_type' => 3])
            ->field('codes,send_datetime')
            ->find();
        if($codes != $inserts['codes']){
            return json(['code'=>0,'msg'=>'验证码错误！']);
        }
        //验证时间
        $now = date('Y-m-d H:i:s');
        //发送时间
        $datetime = date($inserts['send_datetime'],strtotime("+5 minute"));
        if($now > $datetime){
            return json(['code'=>0,'msg'=>'验证超时！']);
        }
        return json(['code'=>1,'msg'=>'验证成功！']);
    }


    //把对象转换成数组的方法；
    public function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }

}