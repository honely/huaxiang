<?php


namespace app\xcx\model;
use think\Db;
use think\Model;
class Msgs extends Model
{
    public function createTouch($uId,$ulId){
        //检查是否有已经创建的会话
        date_default_timezone_set("Australia/Melbourne");
        $time = date('Y-m-d H:i:s');
        $isRepeat = Db::table('xcx_msg_person')
            ->where("(mp_u_id = ".$uId." and mp_ul_id = ".$ulId.") or (mp_ul_id = ".$uId." and mp_u_id = ".$ulId." )")
            ->field('mp_id')
            ->find();
        if($isRepeat['mp_id']){
            //更新会话时间
            Db::table('xcx_msg_person')->where(['mp_id' => $isRepeat['mp_id']])->update(['mp_mod_time' => $time]);
            return $isRepeat['mp_id'];
        }else{
            $data['mp_u_id'] = $uId;
            $data['mp_ul_id'] = $ulId;
            $data['mp_add_time'] = $time;
            $data['mp_mod_time'] = $time;
            $insert = Db::table('xcx_msg_person')->insertGetId($data);
            return $insert ? $insert : 0;
        }

    }


    public function sendAus($code,$phone){
        $phone = trim($phone);
        $text = "[$code] Mobile update. You're changing your mobile on WELHOME. Expire in 3 mins.";
        $phone_number = array($phone);
        $res = $this->sendSms($text,$phone_number);
        $obj = json_decode($res);
        $json = $this->object2array($obj);
        $metaObj = $json['meta'];
        $meta = $this->object2array($metaObj);
        return $meta['code'];
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

    public function sendSms($text, $phone_number) {
        $url = 'https://cellcast.com.au/api/v3/send-sms'; //API URL
        $fields = array(
            'sms_text' => $text,
            'numbers' => $phone_number
        );
        $headers = array(
            'APPKEY: CELLCASTec1b8497a00eb78dc24fdf8ea0a04969',
            'Accept: application/json',
            'Content-Type: application/json',
        );
        $res = $this->curlPost($url,$fields,5,$headers,'json');
        return $res;
    }

    /**
     * 传入数组进行HTTP POST请求
     */
    public function curlPost($url, $post_data = array(), $timeout = 5, $header = "", $data_type = "") {
        $header = empty($header) ? '' : $header;
        //支持json数据数据提交
        if($data_type == 'json'){
            $post_string = json_encode($post_data);
        }elseif($data_type == 'array') {
            $post_string = $post_data;
        }elseif(is_array($post_data)){
            $post_string = http_build_query($post_data, '', '&');
        }

        $ch = curl_init();    // 启动一个CURL会话
        curl_setopt($ch, CURLOPT_URL, $url);     // 要访问的地址
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 对认证证书来源的检查   // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        //curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($ch, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);     // Post提交的数据包
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        //curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //模拟的header头
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}