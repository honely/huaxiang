<?php


namespace app\xcx\model;


use think\Model;

class Subscp extends Model
{

    public function getAckToken() {
        $appid = config('wx.appid');
        $appsecret = config('wx.appsecret');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $res = $this->curl_get($url);
        $res = json_decode($res, true);
        $accktoken = $res['access_token'];
        return $accktoken;
    }

    /***
     * @param $uNick  string 发送者昵称
     * @param $uOpen string 接受者openid
     * @param $stime string 消息发送时间
     * @return bool|string
     */
    public function sendMessage($uNick,$uOpen,$stime)
    {
        $access_token = $this->getAckToken();
        //要发送给微信接口的数据
        $send_data = [
            //用户openId
            "touser" => $uOpen,
            //模板id
            "template_id" => "9NEqSIAuFl9AjDItgILGP1iNAP-vgCOWEVuiGYie1a0",
            //指定发送到开发版
            "miniprogram_state" => "trial",
            "page" => "pages/list/list",
            'data' =>[
                'thing4' =>[
                    'value' => $uNick
                ],
                'time3' =>[
                    'value' => $stime
                ],
                'phrase8' =>[
                    'value' => '新消息提醒'
                ],
                'thing7' =>[
                    'value' => '请点击详情查看。'
                ],
            ]
        ];
        //将路径中占位符%s替换为$access_token值
        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=".$access_token;
        $ret = $this->curl_post($url, $send_data);
        return $ret;
    }

    function curl_get($url){

        $header = array(
            'Accept: application/json',
        );
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 超时设置,以秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);

        // 超时设置，以毫秒为单位
        // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //执行命令
        $data = curl_exec($curl);

        // 显示错误信息
        if (curl_error($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // 打印返回的内容
            return $data;
//            var_dump($data);
//            curl_close($curl);
        }
    }

    /**
     * 传入数组进行HTTP POST请求
     */

    function curl_post($url, array $params = array())
    {
        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json'
            )
        );
        $data = curl_exec($ch);
        curl_close($ch);
        return ($data);
    }
}