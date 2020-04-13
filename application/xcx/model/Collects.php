<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Collects extends Model
{

    public function addCollect($uid,$hid,$type){
        $data['cl_user_id'] = $uid;
        $data['cl_house_id'] = $hid;
        $data['cl_type'] = $type;
        $data['cl_addtime'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_collect')->insertGetId($data);
        //更新房源收藏量  浏览类型1房源；2找室友
        if($type == 1 ){
            Db::table('tk_houses')->where(['id' =>$hid])->setInc('collection');
        }else{
            Db::table('tk_roommates')->where(['id' =>$hid])->setInc('collection');
        }
        return $insert ? $insert : 0;
    }

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_collect')
            ->join('tk_houses','xcx_collect.cl_house_id = tk_houses.id')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field('xcx_collect.*,tk_houses.title,tk_houses.price,tk_houses.images,tk_houses.tags,tk_houses.home')
            ->select();
        if($result){
            foreach ($result as $k => $v){
                if($v['images']){
                    $result[$k]['images'] = explode(',',$v['images'])[0];
                }
            }
        }
        return $result ? $result :  null;
    }

    public function readDataM($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_collect')
            ->join('tk_roommates','xcx_collect.cl_house_id = tk_roommates.id')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field('xcx_collect.*,tk_roommates.title,tk_roommates.price')
            ->select();
        return $result ? $result :  null;
    }

}