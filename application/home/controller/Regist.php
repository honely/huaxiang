<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
use think\Loader;

class Regist extends Controller
{
    public function index(){
        $u_id = trim($this->request->param('u_id','0','intval'));
    	$this->assign('u_id',$u_id);
        return $this->fetch();
    }
    /***
     * 发送短信验证码
     * @return \think\response\Json
     */
    public function sendMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
        $sems = new \SmsDemo();
        $code = mt_rand(999, 9999);
        $data['phone'] = $phone;
        $data['code'] = $code;
        $sem1=$sems->sendSms($phone,$code);
        $array=$this->object2array($sem1);
        if($array['Code'] == 'OK'){
            return  json(['code' => '1','msg' => '短信发送成功！','data' =>$data]);
        }else{
            return  json(['code' => '0','msg' => '短信发送失败！']);
        }
    }


    public function sendMsg1(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
        $sems = new \SmsDemo();
        $code = mt_rand(999, 9999);
        $data['phone'] = $phone;
        $data['code'] = $code;
        $sem1=$sems->sendSms1($phone,$code);
        $array=$this->object2array($sem1);
        if($array['Code'] == 'OK'){
            return  json(['code' => '1','msg' => '短信发送成功！','data' =>$data]);
        }else{
            return  json(['code' => '0','msg' => '短信发送失败！']);
        }
    }


    /***
     * 绑定手机号
     * @return \think\response\Json
     */
    public function bindPhone(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $u_id = trim($this->request->param('u_id'));
        $phone = trim($this->request->param('phone'));
        $verify = trim($this->request->param('verify'));
        $sePhone = trim($this->request->param('vphone'));
        $seCode = trim($this->request->param('vcode'));
        $data['phone'] = $phone;
        $data['verify'] = $verify;
        $data['sePhone'] = $sePhone;
        $data['seCode'] = $seCode;
        $data['u_id'] = $u_id;
        if($phone != $sePhone){
            return  json(['code' => '0','msg' => '手机号有误！','data' => $data]);
        }
        if($verify != $seCode){

            return  json(['code' => '0','msg' => '验证码有误！','data' => $data]);
        }
        $bindPhone = Db::table('web_user')
            ->where(['u_id' => $u_id])
            ->update(['u_phone' => $phone]);
        if(!$bindPhone){
            return  json(['code' => '0','msg' => '绑定手机号失败！','data' => $data]);
        }
        return  json(['code' => '1','msg' => '绑定成功！','data' => $data]);
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