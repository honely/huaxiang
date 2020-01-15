<?php
namespace app\home\controller;
use think\cache\driver\Redis;
use think\Controller;
use think\Db;

class Login extends Controller
{

    public function index(){
        $code = trim($this->request->param('code'));
        $accessToken = $this->oauth2_access_token($code);
        if($accessToken){
            $access_token = $accessToken['access_token'];
            $openid = $accessToken['openid'];
            $userInfo = $this->oauth2_get_user_info($access_token,$openid);
            //根据unionid判断用户是否注册
            $userIsReg = $this->userIsReg($userInfo);
            $u_id = $userIsReg['data']['u_id'];
            if($userIsReg['code'] == 1){
                $this->redirect('home/whouse/index',['u_id' => $u_id]);
            }elseif ($userIsReg['code'] == 2){
                $this->redirect('home/regist/index',['u_id' => $u_id]);
            }else{
            }
        }

    }


    //个人中心
    public function indexs(){
        $code = trim($this->request->param('code'));
        $accessToken = $this->oauth2_access_token($code);
        if($accessToken){
            $access_token = $accessToken['access_token'];
            $openid = $accessToken['openid'];
            $userInfo = $this->oauth2_get_user_info($access_token,$openid);
            //根据unionid判断用户是否注册
            $userIsReg = $this->userIsReg($userInfo);
            $u_id = $userIsReg['data']['u_id'];
            if($userIsReg['code'] == 1){
                $this->redirect('home/my/index',['u_id' => $u_id]);
            }elseif ($userIsReg['code'] == 2){
                $this->redirect('home/regist/index',['u_id' => $u_id]);
            }else{
            }
        }

    }


    /***
     * 判断用户是否注册
     * @param $userInfo
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function userIsReg($userInfo){
        $openid = $userInfo['openid'];
        $unionid = $userInfo['unionid'];
        $isReg = Db::table('web_user')
            ->where(['u_openid' => $openid,'u_unionid' => $unionid])
            ->find();
        if($isReg){
            $code = 1;
            $msg = '已注册的用户！';
            $data = $isReg;
        }else{
            $users['u_openid'] = $userInfo['openid'];
            $users['u_nickname'] = $userInfo['nickname'];
            $users['u_sex'] = $userInfo['sex'];
            $users['u_avatar'] = $userInfo['headimgurl'];
            $users['u_unionid'] = $userInfo['unionid'];
            $users['u_add_time'] = date('Y-m-d H:i:s');
            $addNew = Db::table('web_user')->insertGetId($users);
            if($addNew){
                $code = 2;
                $msg = '微信授权登录添加新用户成功！';
                $data['u_id'] = $addNew;
            }else{
                $code = 3;
                $msg = '添加新用户失败！';
                $data = null;
            }
        }
        $res['code'] = $code;
        $res['msg'] = $msg;
        $res['data'] = $data;
        return $res;
    }


    /****
     * 微信第三方授权用code换取用户的  access_token  and openid
     * @param $code
     * @return array
     */
    public function oauth2_access_token($code)
    {
        $appid = 'wxa15b51c9f9cd03b6';
        $appsecret = '7623e83ed7863be92dd2acf5f7ce29be';
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $res = file_get_contents($url);
        return $this->objToArr(json_decode($res));
    }


    /***
     * 把对象转化为数组
     * @param $obj
     * @return array
     */
    public function objToArr($obj){
        $data = array();
        foreach ($obj as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }

    /***
     * 通过accessToken 和 openid 来换取用户信息
     * @param $access_token
     * @param $openid
     * @return mixed
     */

    public function oauth2_get_user_info($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = file_get_contents($url);
        return $this->objToArr(json_decode($res));
    }


    /***
     * 获取登录地址的方法（测试使用）
     * @return string
     */
    public function getUrl(){
        $appid = 'wxa15b51c9f9cd03b6';
        $scope = 'snsapi_login';
        $state = '';
        $redirect_url = 'https://oa.huaxiangxiaobao.com/home/login/index';
        $url = "https://open.weixin.qq.com/connect/qrconnect?appid=".$appid."&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        return $url;
    }
}