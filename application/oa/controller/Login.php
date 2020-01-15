<?php
/**
 *Author:DangMengmeng
 *Dates:2019/10/30
 *Times:17:31
 */
namespace app\oa\controller;
use think\Controller;
use think\Cookie;
use think\Db;

class Login extends Controller{
    public function logins(){
        if($_POST){
            $user=trim($_POST['user']);
            $pwd=md5(trim($_POST['pwd']));
            if(empty($user)){
                $this->error('请输入手机号或密码进行登录！','login');
            }else{
                if(empty($pwd)){
                    $this->error('请输入密码！','login');
                }else{
                    $login=Db::table('super_admin')
                        ->where("ad_bid = '".$user."' and ad_isable = 1")
                        ->find();
                    if($login){
                        $pwds=$login['ad_password'];
                        if($pwd == $pwds){
                            $config_cookie = [
                                'prefix'    => 'admin', // cookie 名称前缀
                                'expire'    => 1800, // cookie 保存时间
                                'path'      => '/', // cookie 保存路径
                                'domain'    => '', // cookie 有效域名
                                'secure'    => false, //  cookie 启用安全传输
                                'httponly'  => false, // httponly 设置
                                'setcookie' => true, // 是否使用 setcookie
                            ];
                            Cookie::set('user',$login['ad_bid'],7600);
                            Cookie::set('pwds',$login['ad_password'],7600);
                            Cookie::set('ad_id',$login['ad_id'],7600);
                            $this->success('登录成功！');
                        }else{
                            $this->error('账号或者密码错误！','logins');
                        }
                    }else{
                        $this->error('没有此账户信息，或权限异常，请联系管理员！');
                    }
                }
            }
        }else{
            return $this->fetch();
        }
    }

    public function login(){
        if($_POST){
            $user=trim($_POST['user']);
            $pwd=md5(trim($_POST['pwd']));
            if(empty($user)){
                $this->error('请输入手机号或密码进行登录！','login');
            }else{
                if(empty($pwd)){
                    $this->error('请输入密码！','login');
                }else{
                    $login=Db::table('super_admin')
                        ->where("ad_bid = '".$user."' and ad_isable = 1")
                        ->find();
                    if($login){
                        $pwds=$login['ad_password'];
                        if($pwd == $pwds){
                            $config_cookie = [
                                'prefix'    => 'admin', // cookie 名称前缀
                                'expire'    => 1800, // cookie 保存时间
                                'path'      => '/', // cookie 保存路径
                                'domain'    => '', // cookie 有效域名
                                'secure'    => false, //  cookie 启用安全传输
                                'httponly'  => false, // httponly 设置
                                'setcookie' => true, // 是否使用 setcookie
                            ];
                            Cookie::set('user',$login['ad_bid'],7600);
                            Cookie::set('pwds',$login['ad_password'],7600);
                            Cookie::set('ad_id',$login['ad_id'],7600);
                            $this->success('登录成功！');
                        }else{
                            $this->error('账号或者密码错误！','login');
                        }
                    }else{
                        $this->error('没有此账户信息，或权限异常，请联系管理员！');
                    }
                }
            }
        }else{
            return $this->fetch();
        }
    }
}