<?php
namespace app\xcx\model;
use think\Db;
use think\Model;
class Reports extends Model
{
    public function addReport($uId,$mid,$content,$type,$userName,$title){
        $data['user_id'] = $uId;
        $data['p_id'] = $mid;
        $data['user_name'] = $userName;
        $data['content'] = $content;
        $data['type'] = $type;
        $data['title'] = $title;
        $data['status'] = 0;
        $data['cdate'] = date('Y-m-d H:i:s');
        $addHouse = Db::table('tk_report')->insertGetId($data);
        return $addHouse ? $addHouse :  0;
    }

}