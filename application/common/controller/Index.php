<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/6/7
 * Time: 17:14
 */
namespace app\common\controller;
use think\Controller;
use think\Db;

class Index extends Controller{


    //SEO相关
    public function getUrl($controller,$action){
        $navUrl=$controller."/".$action;
        $seoInfo=Db::table('qbl_nav')->where(['nav_url' => $navUrl])->find();
        return $seoInfo;
    }



    //获取连接中关键字的方法
    public function saveKeyword($domain,$path){
        $keywords="";
        if(strpos($domain, 'google.com.tw')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // google taiwan
        }
        if(strpos($domain,'google.cn')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // google china
        }
        if(strpos($domain,'google.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // google
        }elseif(strpos($domain,'baidu.')!==false && preg_match('/wd=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // baidu
        }elseif(strpos($domain,'baidu.')!==false && preg_match('/word=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // baidu
        }elseif(strpos($domain,'114.vnet.cn')!== false && preg_match('/kw=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // ct114
        }elseif(strpos($domain,'iask.com')!==false && preg_match('/k=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // iask
        }elseif(strpos($domain,'soso.com')!==false && preg_match('/w=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // soso
        }elseif(strpos($domain, 'sogou.com')!==false && preg_match('/query=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // sogou
        }elseif(strpos($domain,'so.163.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // netease
        }elseif(strpos($domain,'yodao.com')!== false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // yodao
        }elseif(strpos($domain,'zhongsou.com')!==false && preg_match('/word=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // zhongsou
        }elseif(strpos($domain,'search.tom.com')!==false && preg_match('/w=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // tom
        }elseif(strpos($domain,'live.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // MSLIVE
        }elseif(strpos($domain, 'tw.search.yahoo.com')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // yahoo taiwan
        }elseif(strpos($domain,'cn.yahoo.')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // yahoo china
        }elseif(strpos($domain,'yahoo.')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // yahoo
        }elseif(strpos($domain,'msn.com.tw')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // msn taiwan
        }elseif(strpos($domain,'msn.com.cn')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // msn china
        }elseif(strpos($domain,'msn.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
            $keywords = urldecode($regs[1]); // msn
        }
        return $keywords;
    }
    //获取
    public function getOS($user_agent){
        if(stripos($user_agent, 'Windows')) {
            $brand = 'windows';
        } elseif(stripos($user_agent,"iPhone")!==false){
            $brand= 'iPhone';
        } else if(stripos($user_agent,"SAMSUNG")!==false||stripos($user_agent,"Galaxy")!==false||strpos($user_agent,"GT-")!==false||strpos($user_agent,"SCH-")!==false){
            $brand='三星';
        }elseif(stripos($user_agent,"Huawei")!==false||stripos($user_agent,"Honor")!==false||stripos($user_agent,"H60-")!==false||stripos($user_agent,"H30-")!==false){
            $brand='华为';
        }elseif(stripos($user_agent,"Lenovo")!==false){
            $brand='联想';
        }elseif(strpos($user_agent,"MI-ONE")!==false||strpos($user_agent,"MI 1S")!==false||strpos($user_agent,"MI 2")!==false||strpos($user_agent,"MI 3")!==false||strpos($user_agent,"MI 4")!==false||strpos($user_agent,"MI-4")!==false){
            $brand='小米';
        }elseif(strpos($user_agent,"HM NOTE")!==false||strpos($user_agent,"HM201")!==false){
            $brand='红米';
        }elseif(stripos($user_agent,"Coolpad")!==false||strpos($user_agent,"8190Q")!==false||strpos($user_agent,"5910")!==false){
            $brand='酷派';
        }elseif(stripos($user_agent,"ZTE")!==false||stripos($user_agent,"X9180")!==false||stripos($user_agent,"N9180")!==false||stripos($user_agent,"U9180")!==false){
            $brand='中兴';
        }elseif(stripos($user_agent,"OPPO")!==false||strpos($user_agent,"X9007")!==false||strpos($user_agent,"X907")!==false||strpos($user_agent,"X909")!==false||strpos($user_agent,"R831S")!==false||strpos($user_agent,"R827T")!==false||strpos($user_agent,"R821T")!==false||strpos($user_agent,"R811")!==false||strpos($user_agent,"R2017")!==false){
            $brand='OPPO';
        }elseif(strpos($user_agent,"HTC")!==false||stripos($user_agent,"Desire")!==false){
            $brand='HTC';
        }elseif(stripos($user_agent,"vivo")!==false){
            $brand='vivo';
        }elseif(stripos($user_agent,"K-Touch")!==false){
            $brand='天语';
        }elseif(stripos($user_agent,"Nubia")!==false||stripos($user_agent,"NX50")!==false||stripos($user_agent,"NX40")!==false){
            $brand='努比亚';
        }elseif(strpos($user_agent,"M045")!==false||strpos($user_agent,"M032")!==false||strpos($user_agent,"M355")!==false){
            $brand='魅族';
        }elseif(stripos($user_agent,"DOOV")!==false){
            $brand='朵唯';
        }elseif(stripos($user_agent,"GFIVE")!==false){
            $brand='基伍';
        }elseif(stripos($user_agent,"Gionee")!==false||strpos($user_agent,"GN")!==false){
            $brand='金立';
        }elseif(stripos($user_agent,"HS-U")!==false||stripos($user_agent,"HS-E")!==false){
            $brand='海信';
        }elseif(stripos($user_agent,"Nokia")!==false){
            $brand='诺基亚';
        }else{
            $brand='其他手机';
        }
        return $brand;
    }
    //获取网络状态
    public function getNetType ($Agent)
    {
        $netType = "";
        if (strpos($Agent, 'NetType/WIFI')) {
            $netType = "WIFI";
        } else if (strpos($Agent, 'NetType/4')) {
            $netType = "4G";
        } else if (strpos($Agent, 'NetType/3')) {
            $netType = "3G";
        } else if (strpos($Agent, 'NetType/2')) {
            $netType = "2G";
        } else {
            $netType = "Internet";
        }
        return $netType;
    }



    public function getCityName(){
        $city=Db::table('super_city')
            ->order('c_opeatime')
            ->field('c_id,c_name')
            ->select();
        return $city?$city:null;
    }
}