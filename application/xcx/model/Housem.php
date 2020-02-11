<?php
namespace app\xcx\model;
use think\Db;
use think\Model;

class Housem extends Model
{

    /***
     * @param $where
     * @param $order
     * @param $limit
     * @param $page
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by Dangmengmeng At 2020/1/22 15:05
     */
    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('tk_houses')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field($field)
            ->select();
        if($result){
            foreach ($result as $k => $v){
                $result[$k]['images'] = $this->formatImg($v['images']);
            }
        }
        return $result ? $result :  null;
    }


    public function addHouse($data){
        $addHouse = Db::table('tk_houses')->insertGetId($data);
        return $addHouse ? $addHouse :  0;
    }

    public function editHouse($data){
        $id = $data['id'];
        unset($data['id']);
        $update = Db::table('tk_houses')
            ->where(['id' => $id])
            ->update($data);
        return $update ? $id : 0;
    }

    public function formatImg($imgs){
        $imgsa = explode(',',$imgs);
        $img = $imgsa[0];
        return $img;
    }

    public function getHouse($id){
        $house = Db::table('tk_houses')
            ->where(['id' => $id])
            ->find();
        return $house ? $house : null;
    }
}