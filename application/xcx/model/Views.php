<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Views extends Model
{
    public function addView($uid,$hid,$type){
        $data['vh_userid'] = $uid;
        $data['vh_house_id'] = $hid;
        $data['vh_type'] = $type;
        $data['vh_add_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_view_history')->insertGetId($data);
        return $insert ? $insert : 0;
    }

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_view_history')
            ->join('tk_houses','xcx_view_history.vh_house_id = tk_houses.id')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field('xcx_view_history.*,tk_houses.title,tk_houses.price,tk_houses.images,tk_houses.tags,tk_houses.home')
            ->select();
        return $result ? $result :  null;
    }

    public function readDataV($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_view_history')
            ->join('tk_roommates','xcx_view_history.cl_house_id = tk_roommates.id')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field('xcx_view_history.*,tk_roommates.title,tk_roommates.price')
            ->select();
        return $result ? $result :  null;
    }

}