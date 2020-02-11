<?php
namespace app\api\controller;
use app\xcx\model\Housem;
use think\Controller;
class Index extends Controller
{

    public function house(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $housem = new Housem();
        $where = ['tj' => '是'];
        $filed = 'id,type,house_room,area,images,price,furniture,home,school,address';
        $house = $housem->readData($where,'id desc','12','0',$filed);
        if($house){
            foreach ($house as $k => $v){
                $house[$k]['title'] = $v['type'].''.$v['house_room'].''.$v['area'];
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $house;
        return json($res);
    }

}