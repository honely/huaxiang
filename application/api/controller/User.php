<?php


namespace app\api\controller;


use think\Controller;
use think\Db;
use think\Log;

class User extends Controller
{

    public function login() {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->param();
        if (!@$data['nickname']) {
            $this->sucess(0, '昵称不能为空','1');
        }
        if (!@$data['openid']) {
            $this->sucess('0', 'openid不能为空','2');
        }
        if (!@$data['avaurl']) {
            $this->sucess('0', '头像不能为空','3');
        }
        if (!isset($data['gender'])) {
            $this->sucess('0', '性别不能为空','4');
        }
        switch ($data['gender']){
            case 1:
                $sex = '男';
                break;
            case 2:
                $sex = '女';
                break;
            default:
                $sex = '未知';
                break;
        }
        $data['sex'] = $sex;
        unset($data['gender']);
        //登录
        $user = Db::table('tk_user')
            ->where('openid', $data['openid'])
            ->field('id,openid,nickname,birth,sex,real_name,tel,avaurl')
            ->find();
        if(!empty($user)) {
            $bltoken = $this->saveBlToken($user['id']);
            $return['user'] = $user;
            $return['bltoken'] = $bltoken['data'];
            $this->sucess('1', 'ok', $return);
        } else {
            //保存张哈
            if(isset($data['/api/user/login'])){
                unset($data['/api/user/login']);
            }
            $res = $this->saveUserData($data);
            if ($res['code']) {
                $this->sucess('0', '账号信息保存失败,请联系管理员','222');
            }
            $user = $res['data'];
        }

        //bltoken 添加更新
        $bltoken = $this->saveBlToken($user['id']);
        if ($bltoken['code']) {
            $this->sucess('0', '登录失败','111');
        }
        $return['user'] = $user;
        $return['bltoken'] = $bltoken['data'];
        $this->sucess('1', 'ok', $return);
    }

    public function checkOpenid(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->param();
        if (!@$data['openid']) {
            $this->sucess(0, 'openid不能为空','');
        }else{
            $user = Db::table('tk_user')
                ->where('openid', $data['openid'])
                ->field('id,openid,nickname,birth,sex,real_name,tel,avaurl')
                ->find();
            if($user){
                $this->sucess(1, '用户信息存在',$user);
            }else{
                $this->sucess(0, '没有此用户信息','');
            }
        }
    }

    public function saveBlToken($user_id){
        $bltoken = Db::table('tk_bltoken')->where(['user_id' => $user_id])->find();
        //更新上次登录时间
        Db::table('tk_user')->where(['id' => $user_id])->update(['mdate' =>date('Y-m-d H:i:s')]);
        $data['user_id'] = $user_id;
        $data['blToken'] = md5(date('Y-m-d H:i:s'). $user_id);
        $data['overtime'] = time() + 60 * 60 * 24*30*12;
        if ($bltoken) {
            $data['id'] = $bltoken['id'];
        }
        $res = $this->saveBltokenData($data);
        return $res;
    }

    public function saveBltokenData($data){

        if (!@$data['id']) {
            //添加
            unset($data['id']);
            $id = Db::table('tk_bltoken')->insertGetId($data);
            if (!$id) {
                return ['code' => -1, 'msg' => '保存失败'];
            }
            $data['id'] = $id;
            return ['code' => 0, 'msg' => '保存成功', 'data' => $data];
        } else {
            $res = Db::table('tk_bltoken')->where(['id' => $data['id']])->update($data);
            if ($res == false) {
                return ['code' => -1, 'msg' => '保存失败'];
            }
            return ['code' => 0, 'msg' => '保存成功', 'data' => $data];
        }
    }

    public function saveUserData($data) {
        $now = date('Y-m-d H:i:s');
        $data['mdate'] = $now;
        if (isset($data['id']) && intval($data['id'] <= 0)) {
            unset($data['id']);
        }
        if (!isset($data['id'])) {
            $data['cdate'] = $now;
            $data['email'] = "";
            $id = Db::table('tk_user')->insertGetId($data);
            if (!$id) {
                return ['code' => -1, 'msg' => '添加数据失败'];
            }
            $data['id'] = $id;
            $datas = Db::table('tk_user')
                ->where(['id' => $id])
                ->field('id,openid,nickname,birth,sex,real_name,tel,avaurl')
                ->find();
        } else {
            $data['id'] = intval($data['id']);
            if ($data['id'] <= 0) {
                return ['code' => -1, 'msg' => 'id 必须大于0'];
            }
            $result = Db::table('tk_user')->where(['id' => $data['id']])->update($data);
            if ($result === false) {
                return ['code' => -1, 'msg' => '修改数据失败'];
            }
            $datas = Db::table('tk_user')
                ->where(['id' => $data['id']])
                ->field('id,openid,nickname,birth,sex,real_name,tel,avaurl')
                ->find();
        }
        return ['code' => 0, 'msg' => 'ok', 'data' => $datas];
    }


    /***
     *
     */
    public function get_code() {
        $data = input('param.');
        if (!isset($data['code']) || !$data['code']) {
            $this->sucess(0,"code 为空");
        }
        $res = $this->code2Session($data['code']);
        if (@$res['errcode']) {
            $this->sucess('0', $res['errmsg'] . $res['errcode']);
        }
        $this->sucess('1', 'ok', $res);
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

    public function code2Session_web($code) {
        $appid = config('wx.appid');
        $appsecret = config('wx.appsecret');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". $appid ."&secret=". $appsecret ."&code=". $code ."&grant_type=authorization_code";
        // echo $url;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        // var_dump($res);exit;
        return $res;
    }

    public function get_userid_by_open_id() {
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:*');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $data = input('param.');

        //网页登录
        $user = Db::table('tk_user')->where('unionid', $data['unionid'])->find();
        if (!empty($user)) {
            // $res = model
            $res = $user['id'];
        } else {
            //保存张哈
            $this->sucess('-1', '请先登录一次小程序');
        }
        return $res;
    }

    public function getLogin() {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->param();
        if (!@$data['code']) {
            $this->sucess(0, 'code 为空');
        }
        if (!@$data['encryptedData']) {
            $this->sucess('0', 'encryptedData为空');
        }
        if (!@$data['iv']) {
            $this->sucess('0', 'iv为空');
        }
        $appid = config('wx.appid');
        $secret = config('wx.appsecret');
        $code = $data['code'];
        $encryptedData = $data['encryptedData'];
        $iv = $data['iv'];
        $URL = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
        $apiData=file_get_contents($URL);
        if(!isset($apiData['errcode'])){
            $res = json_decode($apiData);
            $resArry = $this->objectToarray($res);
            $sessionKey = $resArry['session_key'];
            $errCode = $this->decryptData($appid,$sessionKey,$encryptedData,$iv);
            if ($errCode != -41001 &&$errCode != -41002&&$errCode != -41003&&$errCode != -41004) {
                return $res;
            }
        }
    }

    function objectToarray($stdclassobject)
    {
        $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
        foreach ($_array as $key => $value) {
            $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
            $array[$key] = $value;
        }
        return $array;
    }

    public function getPhone(){
        $data = input('param.');
        $appid = config('wx.appid');
        if (!isset($data['session_key']) || !$data['session_key']) {
            $this->sucess(0,"session_key 为空");
        }
        if (!isset($data['encryptedData']) || !$data['encryptedData']) {
            $this->sucess(0,"encryptedData 为空");
        }
        if (!isset($data['iv']) || !$data['iv']) {
            $this->sucess(0,"iv 为空");
        }
        $encryptedData = $data['encryptedData'];
        $iv = $data['iv'];
        $sessionKey=$data['session_key'];
        $res = $this->decryptDatas($encryptedData, $iv,$sessionKey);
        return json($res);

    }

    // 小程序解密
    public function decryptDatas($encryptedData, $iv,$sessionKey)
    {

        $OK = 0;
        $IllegalAesKey = -41001;
        $IllegalIv = -41002;
        $IllegalBuffer = -41003;
        $appid = config('wx.appid');

        if (strlen($sessionKey) != 24) {
            return $IllegalAesKey;
        }
        $aesKey=base64_decode($sessionKey);


        if (strlen($iv) != 24) {
            return $IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return $IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $appid)
        {
            return $IllegalBuffer;
        }

        return  $dataObj;
    }


    public function code2Session_new($code,$encryptedData, $iv) {
        $appid = config('wx.appid');
        $appsecret = config('wx.appsecret');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=". $appid ."&secret=". $appsecret ."&js_code=". $code ."&grant_type=authorization_code";
        // echo $url;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        $sessionKey = $res['session_key'];
        $errCode = $this->decryptData($appid,$sessionKey,$encryptedData,$iv);
        if ($errCode != -41001 &&$errCode != -41002&&$errCode != -41003&&$errCode != -41004) {
            return $res;
        }
        return $res;
    }

    public function ajaxReturn($arr) {
        echo json_encode($arr);
        exit;
    }

    public function sucess($code, $msg = '', $data = '') {
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        echo json_encode($arr);exit;
    }
    /**
     * 微信信息解密
     * @param  string  $appid  小程序id
     * @param  string  $sessionKey 小程序密钥
     * @param  string  $encryptedData 在小程序中获取的encryptedData
     * @param  string  $iv 在小程序中获取的iv
     * @return array 解密后的数组
     */
    function decryptData($appid , $sessionKey, $encryptedData, $iv){
        $OK = 0;
        $IllegalAesKey = -41001;
        $IllegalIv = -41002;
        $IllegalBuffer = -41003;
        $DecodeBase64Error = -41004;

        if (strlen($sessionKey) != 24) {
            return $IllegalAesKey;
        }
        $aesKey=base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return $IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return $IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $appid )
        {
            return $DecodeBase64Error;
        }
        $data = json_decode($result,true);
        return $data;
    }


    public function getShare() {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = $this->request->param('id','1','intval');
        $type = $this->request->param('type','1','intval');
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
        //type = 1 找室友  type = 2 房源
        if ($type == 2) {
            $data['scene'] = 'r' . $id;
            $data['path'] = 'pages/roommateDetail/roommateDetail';
        }else{
            $data['scene'] = 'h' . $id;
            $data['path'] = 'pages/detail/detail';
        }
        $data['width'] = '180';
        $res = $this->http($url, json_encode($data),1);
        if ($type == 2) {
            $path = 'uploads/qrcode/r' . $id . '.jpg';
        }else{
            $path = 'uploads/qrcode/h' . $id . '.jpg';
        }
        file_put_contents($path, $res);

        $return['status_code'] = 2000;
        $return['msg'] = 'ok';
        $return['data'] = config('appurl').'/' . $path;
        // dd($id);
        // echo '<img src="'.$path.'" />';exit;
        echo json_encode($return);exit;
    }




    public function get_access_token() {
        $appid = config('wx.appid');
        $appsecret = config('wx.appsecret');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        if (@$res['errcode']) {
            $return['status_code'] = '2001';
            $return['msg'] = '微信请求失败';
            $return['data'] = '';
            echo json_encode($return);exit;
        }
        // dd($res);
        return $res['access_token'];
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


    public function saveUser(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->param();
        unset($data['/api/user/saveUser']);
        unset($data['/api/user/saveuser']);
        if (!@$data['id']) {
            $res['code'] = 1;
            $res['msg'] = '用户id为空！';
            return json($res);
        }
        $id = $data['id'];
        $data['mdate'] = date('Y-m-d H:i:s');
        unset($data['id']);
        //去除手机号写入时候的空格
        if(isset($data['tel'])){
            $data['tel'] = str_replace(' ', '', $data['tel']);
        }
        $update = Db::table('tk_user')
            ->where(['id' => $id])
            ->update($data);
        if($update){
            $res['code'] = 1;
            $res['msg'] = '修改成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '修改失败！';
        return json($res);
    }


    public function getUser(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = $this->request->param('id');
        if (!@$id) {
            $res['code'] = 1;
            $res['msg'] = '用户id为空！';
            return json($res);
        }
        $user = Db::table('tk_user')
            ->where(['id' => $id])->find();
        if($user){
            unset($user['openid']);
            unset($user['unionid']);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $user;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '无此用户！';
        return json($res);
    }


    public function changePhone(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = $this->request->param('id');
        $phone = $this->request->param('phone');
        $code = $this->request->param('code');
        $ucode = $this->request->param('ucode');
        if (!@$id) {
            $res['code'] = 0;
            $res['msg'] = '用户id为空！';
            return json($res);
        }
        if (!@$phone) {
            $res['code'] = 0;
            $res['msg'] = '手机号为空！';
            return json($res);
        }
        if (!@$code || !@$ucode) {
            $res['code'] = 0;
            $res['msg'] = '验证码为空！';
            return json($res);
        }
        $user = Db::table('tk_user')
            ->where(['id' => $id])
            ->field('tel')
            ->find();
        if(!$user){
            $res['code'] = 0;
            $res['msg'] = '无此用户！';
            return json($res);
        }
        if($code != $ucode){
            $res['code'] = 0;
            $res['msg'] = '验证码错误！';
            return json($res);
        }
        if($user['tel'] == $phone){
            $res['code'] = 0;
            $res['msg'] = '与此前手机号重复！';
            return json($res);
        }
        $update = Db::table('tk_user')
            ->where(['id' => $id])
            ->update(['tel' => $phone]);
        if($update){
            $res['code'] = 1;
            $res['msg'] = '绑定成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '绑定失败！';
        return json($res);
    }
}