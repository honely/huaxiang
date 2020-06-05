<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/6
 * Time: 9:15
 */
namespace app\xcx\controller;
use think\Controller;
use think\Db;
class Login extends Controller{
    //用户登录
    public function login(){
        if($_POST){
            $user=trim($_POST['username']);
            $pwd=md5(trim($_POST['password']));
            if(empty($user)){
                $this->error('请输入工号进行登录！','login');
            }else{
                if(empty($pwd)){
                    $this->error('请输入密码！','login');
                }else{
                    //改为邮箱登录2020年5月27日09:14:36
                    $login=Db::table('super_admin')
                        ->where(['ad_email' => $user,'ad_isable' => 1])
                        ->find();
                    if($login){
                        $pwds=$login['ad_password'];
                        if($pwd == $pwds){
                            session('adminName',$login['ad_realname']);
                            session('adminId',$login['ad_id']);
                            session('ad_bid',$login['ad_bid']);
                            session('ad_role',$login['ad_role']);
                            session('ad_wechat',$login['ad_wechat']);
                            session('expiretime',time() + 1800);
                            $this->success('登录成功！','index/index');
                        }else{
                            $this->error('账号或者密码错误！','login');
                        }
                    }else{
                        $this->error('没有此账户信息，或账号异常，请联系管理员！');
                    }
                }
            }
        }else{
            return $this->fetch();
        }
    }


    public function loginOut()
    {
        session(null);
        $this->success('欢迎再来','https://huaxiangxiaobao.com/', 3);
    }
}