<?php
namespace app\xcx\model;
use think\Db;
use think\Model;
class Helpm extends Model
{


    public function addHelp($data){
        //查询是否有相同的数据写入
        
        $addHouse = Db::table('xcx_helpme')->insertGetId($data);
        $mateInfo = Db::table('xcx_helpme')->where(['h_id' =>$addHouse])->field('h_uid')->find();
        $msg = new Loops();
        $userNick = $msg->getUserNick($mateInfo['h_uid']);
        $str = $userNick.'正在找房子';
        $msg->insertMsg($str);
        return $addHouse ? $addHouse :  0;
    }
    public function editHelp($data){
        $id = $data['h_id'];
        unset($data['h_id']);
        $update = Db::table('xcx_helpme')
            ->where(['h_id' => $id])
            ->update($data);
        return $update ? $id : 0;
    }
}