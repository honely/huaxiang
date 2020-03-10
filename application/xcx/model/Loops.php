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

}