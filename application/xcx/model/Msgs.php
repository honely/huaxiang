<?php


namespace app\xcx\model;
use think\Db;
use think\Model;
class Msgs extends Model
{


    /***
     * @param $uId int 发起者id 此处为前端小程序用户
     * @param $ulId int 接受者id 此处 可能为前端小程序用户  也可能为后端平台用户
     * @param $hId  int 房源id
     * @return int|mixed|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function createTouch($uId,$ulId,$hId){
        //检查是否有已经创建的会话
        //如果是后端发布的房源，小程序用户发起会话给后端管理员
        //如果存在房源id表示是从房源列表发起的会话  要考虑是否为前端用户发送给平台用户的消息
        //如果不存在房源id表示是从找室友发起的会话
        date_default_timezone_set("Australia/Melbourne");
        $time = date('Y-m-d H:i:s');
        if($hId){
            //查询房源的发送人
            $adminInfo = $this->getHouseAddAdminIdViaHouseId($hId);
            $houseTitle = $adminInfo['title'];
            $houseDSN = $adminInfo['dsn'];
            //表明这一条房源记录为后端发送  前端客户和后端平台用户沟通
            if($adminInfo['is_admin'] == 2){
                //前端对后端发送消息 检测是否重复
                //发起者为小程序用户  mp_utype = 1
                //接受者为后端平台用户  mp_ultype = 2
                $ulId = $adminInfo['user_id'];
                $isRepeat = Db::table('xcx_msg_person')
                    ->where("(mp_u_id = ".$uId." and mp_utype = 1 and mp_ul_id = ".$ulId." and mp_ultype = 2 ) or (mp_ul_id = ".$uId." and mp_ultype = 1 and mp_u_id = ".$ulId." and mp_utype = 2 )")
                    ->field('mp_id')
                    ->find();
                if($isRepeat['mp_id']){
                    //更新会话时间
                    Db::table('xcx_msg_person')->where(['mp_id' => $isRepeat['mp_id']])->update(['mp_mod_time' => $time]);
                    return $isRepeat['mp_id'];
                }else{
                    //写入一条创建会话的记录
                    $data['mp_u_id'] = $uId;
                    $data['mp_ul_id'] = $ulId;
                    $data['mp_add_time'] = $time;
                    $data['mp_mod_time'] = $time;
                    $data['mp_ultype'] = 2;
                    $data['mp_utype'] = 1;
                    $insert = Db::table('xcx_msg_person')->insertGetId($data);
                    $msg['xcx_msg_mp_id'] = $insert;
                    $msg['xcx_msg_uid'] = $uId;
                    $msg['xcx_msg_ul_id'] = $ulId;
                    $msg['xcx_msg_u_type'] = 1;
                    $msg['xcx_msg_ul_type'] = 2;
                    $msg['xcx_msg_isread'] = 2;
                      $msg['xcx_msg_content'] = '你好，我想咨询这个房源：（'.$houseTitle.'),房源编号：【'.$houseDSN.'】。';
                    $msg['xcx_msg_add_time'] = $time;
                    Db::table('xcx_msg_content')->insertGetId($msg);
                    return $insert ? $insert : 0;
                }
            }
            if($adminInfo['is_admin'] == 1){
                //前端对前端发送消息 检测是否重复
                //发起者为小程序用户  mp_utype = 1
                //接受者为后端平台用户  mp_ultype = 1
                $ulId = $adminInfo['user_id'];
                $isRepeat = Db::table('xcx_msg_person')
                    ->where("(mp_u_id = ".$uId." and mp_utype = 1 and mp_ul_id = ".$ulId." and mp_ultype = 1 ) or (mp_ul_id = ".$uId." and mp_ultype = 1 and mp_u_id = ".$ulId." and mp_utype = 1 )")
                    ->field('mp_id')
                    ->find();
                if($isRepeat['mp_id']){
                    //更新会话时间
                    Db::table('xcx_msg_person')->where(['mp_id' => $isRepeat['mp_id']])->update(['mp_mod_time' => $time]);
                    return $isRepeat['mp_id'];
                }else{
                    //写入一条创建会话的记录
                    $data['mp_u_id'] = $uId;
                    $data['mp_ul_id'] = $ulId;
                    $data['mp_add_time'] = $time;
                    $data['mp_mod_time'] = $time;
                    $data['mp_ultype'] = 1;
                    $data['mp_utype'] = 1;
                    $insert = Db::table('xcx_msg_person')->insertGetId($data);
                    $msg['xcx_msg_mp_id'] = $insert;
                    $msg['xcx_msg_uid'] = $uId;
                    $msg['xcx_msg_ul_id'] = $ulId;
                    $msg['xcx_msg_u_type'] = 1;
                    $msg['xcx_msg_ul_type'] = 1;
                    $msg['xcx_msg_isread'] = 2;
                    $msg['xcx_msg_content'] = '你好，我想咨询这个房源：（'.$houseTitle.'),房源编号：【'.$houseDSN.'】。';
                    $msg['xcx_msg_add_time'] = $time;
                    Db::table('xcx_msg_content')->insertGetId($msg);
                    return $insert ? $insert : 0;
                }
            }
        }
        //前端对前端发送消息
        $isRepeat = Db::table('xcx_msg_person')
            ->where("(mp_u_id = ".$uId." and mp_utype = 1 and mp_ul_id = ".$ulId." and mp_ultype = 1 ) or (mp_ul_id = ".$uId." and mp_utype = 1 and mp_u_id = ".$ulId." and mp_ultype = 1 )")
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


    public function getHouseAddAdminIdViaHouseId($hid){
        $houseInfo = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->field('is_admin,user_id,title,dsn')
            ->find();
        return $houseInfo ? $houseInfo : null;
    }

    /***
     * 后端管理员向前端用户发起会话
     * @param $adminId int 后台管理员id
     * @param $userId int 前端用户id
     * @return int|mixed|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function adminCreateTouch($adminId,$userId){
        //检查是否有已经创建的会话
        date_default_timezone_set("Australia/Melbourne");
        $time = date('Y-m-d H:i:s');
        $isRepeat = Db::table('xcx_msg_person')
            ->where("(mp_u_id = ".$adminId." and mp_utype = 2 and mp_ul_id = ".$userId." and mp_ultype = 1) or (mp_ul_id = ".$adminId." and mp_ultype = 2 and mp_u_id = ".$userId." and mp_utype = 1 )")
            ->field('mp_id')
            ->find();
        if($isRepeat['mp_id']){
            //更新会话时间
            Db::table('xcx_msg_person')->where(['mp_id' => $isRepeat['mp_id']])->update(['mp_mod_time' => $time]);
            return $isRepeat['mp_id'];
        }else{
            $data['mp_u_id'] = $adminId;
            $data['mp_ul_id'] = $userId;
            $data['mp_add_time'] = $time;
            $data['mp_mod_time'] = $time;
            //发起者为后端用户
            $data['mp_utype'] = 2;
            //接受者为小程序用户
            $data['mp_ultype'] = 1;
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

    public function sendNotice($name,$phone){
        $text = "Hi [$name]，You have unread messages from new clients. Please login to Welhome Agent platform to find out more leads [Welhome]";
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