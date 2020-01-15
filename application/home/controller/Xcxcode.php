<?php
namespace app\home\controller;
use think\Controller;
class Xcxcode extends Controller
{


    /***
     * 小程序生成带参数的二维码【小程序的圆形码】保存成jpg图片上传到服务器
     */
    public function xcxCode() {
        $id = trim($this->request->param('id','5084','intval'));
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
        $data['scene'] = 'h' . $id;
        $data['path'] = 'pages/detail/detail';
        $data['width'] = '430';
        $res = $this->http($url, json_encode($data),1);
        $path = 'uploads/qrcode/h' . $id . '.jpg';
        file_put_contents($path, $res);
        $return['status_code'] = 2000;
        $return['msg'] = 'ok';
        $return['img'] = 'https://oa.huaxiangxiaobao.com/' . $path;
        echo '<img src="'.$return['img'].'" />';exit;
        echo json_encode($return);exit;
    }

        //post curl 请求参数
    function http($url, $data = NULL, $json = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            if($json && is_array($data)){
                $data = json_encode( $data );
            }
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if($json){ //发送JSON数据
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json; charset=utf-8',
                        'Content-Length:' . strlen($data))
                );
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        // var_dump($res);exit;
        $errorno = curl_errno($curl);

        if ($errorno) {
            return array('errorno' => false, 'errmsg' => $errorno);
        }
        curl_close($curl);
        return $res;
    }

    /***
     * 小程序生成带参数的二维码【方形码】保存成jpg图片上传到服务器
     * @return string
     */
    public function getXcxCode(){
        //获取accesstoken
        $ACCESS_TOKEN = $this->getAccessToken();
        $qcode ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$ACCESS_TOKEN;
        //小程序的页面路径
        $param = json_encode(array("path"=>"pages/detail/detail?id=5084","width"=> 150));
        $result = $this->httpRequest( $qcode, $param,"POST");
        //图片保存的绝对路径
        $path = 'uploads/qrcode/h.jpg';
        file_put_contents($path, $result);
        $return['status_code'] = 2000;
        $return['msg'] = 'ok';
        //图片读取的路径
        $return['img'] = 'https://oa.huaxiangxiaobao.com/' . $path;
        echo '<img src="'.$return['img'].'" />';exit;
        echo json_encode($return);exit;
    }


    function httpRequest($url, $data='', $method='GET'){

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);

        if($method=='POST')

        {

            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_HEADER, 0);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;

    }
    public function getAccessToken(){
        $appid = 'wxbaff89f847b0f15f';
        $secret = '14b8b22ba3154f015a3e890613b2029b';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $res = json_decode($this->httpGet($url));
        $access_token = @$res->access_token;
        return $access_token;
    }
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}