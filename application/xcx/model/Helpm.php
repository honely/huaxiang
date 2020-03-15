<?php
namespace app\xcx\model;
use think\Db;
use think\Model;
class Helpm extends Model
{


    public function addHelp($data){
        $addHouse = Db::table('xcx_helpme')->insertGetId($data);
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