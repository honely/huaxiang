<?php
namespace app\api\controller;
use app\xcx\model\Loops;
use think\Controller;

class Loop extends Controller
{

    public function getMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = '1 = 1';
        $order = 'lm_add_time desc';
        $field = 'lm_id,lm_title';
        $mateM = new Loops();
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