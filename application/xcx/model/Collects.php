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
        }elseif($type == 3){
            Db::table('tk_forent')->where(['id' =>$hid])->setInc('collection');
        }else{
            Db::table('tk_roommates')->where(['id' =>$hid])->setInc('collection');
        }
        //更新用户收藏量
        Db::table('tk_user')->where(['id' => $uid])->setInc('count');
        return $insert ? $insert : 0;
    }

    public function readData($where,$order,$limit,$page,$field){
        $where = $where." and is_del =1 and status =1";
        $result = Db::table('xcx_collect')
            ->join('tk_houses','xcx_collect.cl_house_id = tk_houses.id')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field('xcx_collect.*,tk_houses.title,tk_houses.price,tk_houses.images,tk_houses.type,tk_houses.address,tk_houses.thumnail')
            ->select();
        if($result){
            foreach ($result as $k => $v){
                $result[$k]['imgs'] = $v['thumnail'] ? $v['thumnail'].",".$v['images'] : $v['images'];
            }
        }
        return $result ? $result :  null;
    }

    public function readDataM($where,$order,$limit,$page,$field){
        $where = $where." and status =1";
        $result = Db::table('xcx_collect')
            ->join('tk_forent','xcx_collect.cl_house_id = tk_forent.id')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field('xcx_collect.*,tk_forent.title,tk_forent.type,tk_forent.userid')
            ->select();
        if($result){
            $loop = new Loops();
            foreach($result as $k => $v){
                $result[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                $result[$k]['nickname'] = $loop->getUserNick($v['userid']);
            }
        }
        return $result ? $result :  null;
    }

}