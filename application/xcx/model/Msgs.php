<?php


namespace app\xcx\model;
use think\Db;
use think\Model;
class Msgs extends Model
{
    public function createTouch($uId,$ulId){
        $time = date('Y-m-d H:i:s');
        $data['mp_u_id'] = $uId;
        $data['mp_ul_id'] = $ulId;
        $data['mp_add_time'] = $time;
        $data['mp_mod_time'] = $time;
        $insert = Db::table('xcx_msg_person')->insertGetId($data);
        return $insert ? $insert : 0;
    }

}