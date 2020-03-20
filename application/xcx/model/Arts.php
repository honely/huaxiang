<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Arts extends Model
{

    public function readDataQ($where,$order,$limit,$page,$field){
        $result = Db::table('tk_questions')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field($field)
            ->select();
        return $result ? $result :  null;
    }

    public function findData($where,$field){
        $result = Db::table('tk_questions')
            ->where($where)
            ->field($field)
            ->find();
        return $result ? $result :  null;
    }

}