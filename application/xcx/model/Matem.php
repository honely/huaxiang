<?php
namespace app\xcx\model;
use think\Db;
use think\Model;

class Matem extends Model
{

    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('tk_roommates')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field($field)
            ->select();
        return $result ? $result :  null;
    }


    public function addMate($data){
        $data['dsn'] = $this->getMateDsn();
        $addHouse = Db::table('tk_roommates')->insertGetId($data);
        return $addHouse ? $addHouse :  0;
    }

    public function editMate($data){
        $id = $data['id'];
        unset($data['id']);
        $update = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->update($data);
        return $update ? $id : 0;
    }


    public function getMate($id,$uid){
        $house = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->find();
        //写入一条浏览记录
        $view = new Views();
        $view->addView($uid,$id,2);
        return $house ? $house : null;
    }


    //生成找室友编码
    public function getMateDsn()
    {
        $dsn = 'M';
        $max =$this->getMax();
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

    public function getMax(){
        $max = Db::table('tk_roommates')->order('id desc')->find();
        return $max['id'] ? $max['id'] : 0;
    }
}