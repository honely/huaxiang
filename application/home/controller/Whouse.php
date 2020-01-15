<?php
namespace app\home\controller;
use think\Cache;
use think\cache\driver\Redis;
use think\Controller;
use think\Db;

class Whouse extends Controller
{

    public function index(){
        $u_id = trim($this->request->param('u_id','0','intval'));
        $userInfo = Db::table('web_user')
            ->where(['u_id' => $u_id])
            ->field('u_id,u_nickname,u_avatar')
            ->find();
        $this->assign('user',$userInfo);
        $this->assign('u_id',$u_id);
        return $this->fetch();
    }

    public function lists(){
        return $this->fetch();
    }
















    public function get_qrcode() {
        //header('content-type:image/gif');
        //header('content-type:image/png');格式自选，不同格式貌似加载速度略有不同，想加载更快可选择jpg
        header('content-type:image/jpg');
        $id = 5084;
        $data = array();
        $data['scene'] = "id=".$id;
        $data['page'] = "pages/detail/detail";  //参数跳转到product/show，产品详情
        $data['width'] = 150;
        $data = json_encode($data);
        $access_token= $this->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
        $da = $this->get_http_array($url,$data);
        dump($da);
    }
    public function get_http_array($url,$post_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //没有这个会自动输出，不用print_r();也会在后面多个1
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $out = json_decode($output);
        return $out;
    }
















    public function getWxcode(){
        $ACCESS_TOKEN=$this->getAccessToken();
        $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$ACCESS_TOKEN;
        $post_data=
            array(
                'page'=>'pages/detail/detail',
                'scene'=>'id:5084'
            );
        $post_data=json_encode($post_data);
        $data=$this->send_post($url,$post_data);
        $result=$this->data_uri($data,'image/png');
        return '<image src='.$result.'></image>';
    }
    /**
     * 消息推送http
     * @param $url
     * @param $post_data
     * @return bool|string
     */
    protected function send_post( $url, $post_data ) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type:application/json',
                //header 需要设置为 JSON
                'content' => $post_data,
                'timeout' => 60
                //超时时间
            )
        );
        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );
        return $result;
    }
    public function data_uri($contents, $mime)
    {
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
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