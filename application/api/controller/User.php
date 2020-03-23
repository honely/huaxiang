<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class User extends Controller
{

    public function login() {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->param();
        if (!@$data['nickname']) {
            $this->sucess(-1, '昵称不能为空');
        }
        if (!@$data['openid']) {
            $this->sucess('-1', 'openid不能为空');
        }
        if (!@$data['avaurl']) {
            $this->sucess('-1', '头像不能为空');
        }
        //登录
        $user = Db::table('tk_user')->where('openid', $data['openid'])->find();
        if (!empty($user)) {
            //if ($user['unionid'] == null){
            //    $rest = model('User')->where('openid', $data['openid'])->setField('unionid',$data['unionid']);
            //}
        } else {
            //保存张哈
            $res = $this->saveUserData($data);
            if ($res['code']) {
                $this->sucess('-1', '账号信息保存失败,请联系管理员');
            }
            $user = $res['data'];
        }

        //bltoken 添加更新
        $bltoken = $this->saveBlToken($user['id']);
        if ($bltoken['code']) {
            $this->sucess('-1', '登录失败');
        }
        $return['user'] = $user;
        $return['bltoken'] = $bltoken['data'];
        $this->sucess('0', 'ok', $return);
        //dd($bltoken);
    }

    public function saveBlToken($user_id){
        $bltoken = Db::table('tk_bltoken')->where(['user_id' => $user_id])->find();
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
        } else {
            $data['id'] = intval($data['id']);
            if ($data['id'] <= 0) {
                return ['code' => -1, 'msg' => 'id 必须大于0'];
            }
            $result = Db::table('tk_user')->where(['id' => $data['id']])->update($data);
            if ($result === false) {
                return ['code' => -1, 'msg' => '修改数据失败'];
            }
        }
        return ['code' => 0, 'msg' => 'ok', 'data' => $data];
    }

    public function get_code() {
        $data = input('param.');
        if (!isset($data['code']) || !$data['code']) {
            $this->sucess(-2,"code 为空");
        }
        $res = $this->code2Session($data['code']);
        if (@$res['errcode']) {
            $this->sucess('-1', $res['errmsg'] . $res['errcode']);
        }
        $this->sucess('0', 'ok', $res);
    }

    public function code2Session($code) {
        $appid = 'wx45426a13290ecb64';
        $appsecret = '0c323386f153831f379938f2c659fff7';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=". $appid ."&secret=". $appsecret ."&js_code=". $code ."&grant_type=authorization_code";
        // echo $url;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        // var_dump($res);exit;
        return $res;
    }

    public function code2Session_web($code) {
        $appid = 'wx45426a13290ecb64';
        $appsecret = '0c323386f153831f379938f2c659fff7';
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
        $user = model('User')->where('unionid', $data['unionid'])->find();
        if (!empty($user)) {
            // $res = model
            $res = $user['id'];
        } else {
            //保存张哈
            $this->sucess('-1', '请先登录一次小程序');
        }
        return $res;
    }

    public function get_code_new() {
        $data = input('param.');
        if (!isset($data['code']) || !$data['code']) {
            $this->sucess(-2,"code 为空");
        }
        $res = $this->code2Session_new($data['code'],$data['encryptedData'], $data['iv']);
        //if (@$res['errcode']) {
        //	$this->sucess('-1', $res['errmsg'] . $res['errcode']);
        //}
        $this->sucess('0', 'ok', $res);
    }

    public function code2Session_new($code,$encryptedData, $iv) {
        $appid = 'wx45426a13290ecb64';
        $appsecret = '0c323386f153831f379938f2c659fff7';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=". $appid ."&secret=". $appsecret ."&js_code=". $code ."&grant_type=authorization_code";
        // echo $url;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        $sessionKey = $res['session_key'];
        $errCode = $this->decryptData($appid,$sessionKey,$encryptedData,$iv);
        if ($errCode != -41001 &&$errCode != -41002&&$errCode != -41003&&$errCode != -41004) {
            $res['unionid'] = $errCode['unionId'];
            return $res;
        }
        // var_dump($res);exit;
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
}