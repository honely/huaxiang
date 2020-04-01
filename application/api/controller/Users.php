<?php


namespace app\api\controller;


use think\Controller;

class Users extends Controller
{


    public function get_code() {
        $data = input('param.');
        if (!isset($data['code']) || !$data['code']) {
            $this->sucess(-2,"code 为空");
        }
        $res = $this->code2Session($data['code']);
        if (@$res['errcode']) {
            $this->sucess('-1', $res['errmsg'] . $res['errcode']);
        }
        $ress = json_decode(json_encode($res),true);
        $this->sucess('0', 'ok', $ress['openid']);
    }


    public function sucess($code, $msg = '', $data = '') {
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        echo json_encode($arr);exit;
    }


    public function code2Session($code) {
        $appid = config('wx.appid');
        $appsecret = config('wx.appsecret');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=". $appid ."&secret=". $appsecret ."&js_code=". $code ."&grant_type=authorization_code";
        // echo $url;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        return $res;
    }
}