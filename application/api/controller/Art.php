<?php
namespace app\api\controller;
use app\xcx\model\Arts;
use think\Controller;
class Art extends Controller
{

    /***
     *
     */
    public function rent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = "type = '租房'";
        $order = 'cdate desc';
        $field = 'title,summary';
        $mateM = new Arts();
        $mate= $mateM->readDataQ($where,$order,'12','0',$field);
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


    /***
     * 房东相关
     * @return \think\response\Json
     */
    public function lord(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = "type = '房东'";
        $order = 'cdate desc';
        $field = 'title,summary';
        $mateM = new Arts();
        $mate= $mateM->readDataQ($where,$order,'12','0',$field);
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

    public function plat(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = "type = '平台声明'";
        $field = 'title,content';
        $mateM = new Arts();
        $mate= $mateM->findData($where,$field);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $mate;
        return json($res);
    }


    public function about(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = "type = '关于我们'";
        $field = 'title,content';
        $mateM = new Arts();
        $mate= $mateM->findData($where,$field);
        if($mate){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $mate;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $mate;
        return json($res);
    }
}