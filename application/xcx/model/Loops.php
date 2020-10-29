<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Loops extends Model
{

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_loop_msg')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field($field)
            ->select();
        return $result ? $result :  null;
    }

    public function insertMsg($str){
        $add['lm_title'] = $str;
        $add['lm_add_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_loop_msg')->insertGetId($add);
        return $insert ? $insert : 0;
    }


    public function getUserAvatar($uid){
        $user = Db::table('tk_user')->where(['id' => $uid])->field('avaurl')->find();
        return $user ? $user['avaurl'] : '';
    }

    public function getAdminAvatar($adminId){
        $user = Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_img')->find();
        return $user['ad_img'] ? 'https://wx.huaxiangxiaobao.com/'.$user['ad_img'] : 'https://wx.huaxiangxiaobao.com/static/logo.png';
    }
     public function getUserSex($uid){
        $user = Db::table('tk_user')->where(['id' => $uid])->field('sex')->find();
        return $user ? $user['sex'] : '男';
    }
    public function getAdminNick($adminId){
        $user = Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_realname')->find();
        return $user ? $user['ad_realname'] : '外星人';
    }


    public function getUserAvatars($uid,$admin){
        if($admin == 1){
            $user = Db::table('tk_user')->where(['id' => $uid])->field('avaurl')->find();
            $userName = $user ? $user['avaurl'] : '外星人呀';
        }else if($admin == 2){
            $user = Db::table('super_admin')->where(['ad_id' => $uid])->field('ad_img')->find();
            $userName = $user['ad_img'] ? 'https://wx.huaxiangxiaobao.com/'.$user['ad_img'] : 'https://wx.huaxiangxiaobao.com/static/logo.png';
        }
        return $userName;
    }
    
    
    
    public function getUserEmail($uid){
        $user = Db::table('tk_user')->where(['id' => $uid])->field('email')->find();
        return $user ? $user['email'] : '';
    }

    public function getAdminEmail($uid){
        $user = Db::table('super_admin')->where(['ad_id' => $uid])->field('ad_email')->find();
        return $user ? $user['ad_email'] : '';
    }


    public function getUserNick($uid){
        $user = Db::table('tk_user')->where(['id' => $uid])->field('nickname')->find();
        return $user ? $user['nickname'] : '';
    }


    public function getUserNicks($uid,$admin){
        if($admin == 1){
            $user = Db::table('tk_user')->where(['id' => $uid])->field('nickname')->find();
            $userName = $user ? $user['nickname'] : '';
        }else if($admin == 2){
            $user = Db::table('super_admin')->where(['ad_id' => $uid])->field('ad_realname')->find();
            $userName = $user ? $user['ad_realname'] : '';
        }
        return $userName;
    }


   
    public function getUnread($mpId,$uid){
        //更新已读状态
        $isbend = $this->isBindAdmin($uid);
        $bindId = $isbend['ad_id'];
        //更新已读状态
        if($isbend){
            $readWhere = '( xcx_msg_uid != '.$uid.' and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != '.$bindId.' and  xcx_msg_u_type = 2 )';
        }else{
            $readWhere = 'xcx_msg_ul_type = 1 and  xcx_msg_uid != '.$uid;
        }
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
            ->where($readWhere)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0 ;
    }

    public function isBindAdmin($uid){
        $isBind = Db::table('super_admin')->where(['ad_wechat' => $uid])->field('ad_id')->find();
        return $isBind ? $isBind : null;
    }


}