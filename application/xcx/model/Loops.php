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

}