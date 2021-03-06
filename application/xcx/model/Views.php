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
        //查询是否有重复项。
        Db::table('xcx_view_history')
            ->where(['vh_userid' => $uid,'vh_house_id' => $hid ,'vh_type' =>$type])
            ->delete();
        //更新房源浏览量  浏览类型1房源；2找室友
        if($type == 1 ){
            Db::table('tk_houses')->where(['id' =>$hid])->setInc('view');
        }elseif($type == 3){
            Db::table('tk_forent')->where(['id' =>$hid])->setInc('view');
        }

        $insert = Db::table('xcx_view_history')->insertGetId($data);
        return $insert ? $insert : 0;
    }

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_view_history')
            ->join('tk_houses','xcx_view_history.vh_house_id = tk_houses.id')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field('xcx_view_history.*,tk_houses.title,tk_houses.price,tk_houses.images,tk_houses.tags,tk_houses.home')
            ->select();
        return $result ? $result :  null;
    }

    public function readDataV($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_view_history')
            ->join('tk_roommates','xcx_view_history.vh_house_id = tk_roommates.id')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field('xcx_view_history.*,tk_roommates.title,tk_roommates.price')
            ->select();
        return $result ? $result :  null;
    }

}