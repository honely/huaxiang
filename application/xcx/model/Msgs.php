<?php


namespace app\xcx\model;
use think\Db;
use think\Model;
class Msgs extends Model
{
    public function createTouch($uId,$ulId){
        //检查是否有已经创建的会话
        date_default_timezone_set("Australia/Melbourne");
        $time = date('Y-m-d H:i:s');
        $isRepeat = Db::table('xcx_msg_person')
            ->where("(mp_u_id = ".$uId." and mp_ul_id = ".$ulId.") or (mp_ul_id = ".$uId." and mp_u_id = ".$ulId." )")
            ->field('mp_id')
            ->find();
        if($isRepeat['mp_id']){
            //更新会话时间
            Db::table('xcx_msg_person')->where(['mp_id' => $isRepeat['mp_id']])->update(['mp_mod_time' => $time]);
            return $isRepeat['mp_id'];
        }else{
            $data['mp_u_id'] = $uId;
            $data['mp_ul_id'] = $ulId;
            $data['mp_add_time'] = $time;
            $data['mp_mod_time'] = $time;
            $insert = Db::table('xcx_msg_person')->insertGetId($data);
            return $insert ? $insert : 0;
        }

    }

}