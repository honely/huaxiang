<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Loops extends Model
{

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_loop_msg')
            ->where($where)
            ->limit($limit,$page)
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
    public function getUserNick($uid){
        $user = Db::table('tk_user')->where(['id' => $uid])->field('nickname')->find();
        return $user ? $user['nickname'] : '外星人呀';
    }


    public function getUnread($mpId,$uid){
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
            ->where('xcx_msg_uid != '.$uid)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }

}