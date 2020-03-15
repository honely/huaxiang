<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2019/1/21
 * Time: 11:47
 */
namespace app\api\controller;
use app\xcx\model\Bannerm;
use think\Controller;

class Banner extends Controller{


    public function getBan(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = 'b_status = 1';
        $order = 'b_update_time desc';
        $field = 'b_id,b_title,b_cover';
        $mateM = new Bannerm();
        $mate= $mateM->readData($where,$order,'12','0',$field);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $mate;
        return json($res);
    }
}