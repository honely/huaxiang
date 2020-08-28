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
                $this->error('Please Use Email Account to Login！','login');
            }else{
                if(empty($pwd)){
                    $this->error('Password required！','login');
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
                            session('ad_corp',$login['ad_corp']);
                            session('expiretime',time() + 1800);
                            $this->success('Success！','index/index');
                        }else{
                            $this->error('Wrong Account Or Password！','login');
                        }
                    }else{
                        $this->error('No Account Info,please Connect Administrator！');
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
        $this->success('Welcome Back','https://huaxiangxiaobao.com/', 3);
    }
}