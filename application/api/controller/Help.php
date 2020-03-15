<?php
namespace app\api\controller;
use app\xcx\model\Helpm;
use think\Controller;
class Help extends Controller
{

    public function add(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if(!$data){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['h_addtime'] = date('Y-m-d H:i:s');
        $helpm = new Helpm();
        $addHelp = $helpm->addHelp($data);
        if($addHelp){
            $res['code'] = 1;
            $res['msg'] = '写入成功！';
            $res['h_id'] = $addHelp;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '写入失败！';
        return json($res);
    }


    public function edit(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if($data && $data['h_id'] <= 0){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $helpm = new Helpm();
        $addHouse = $helpm->editHelp($data);
        if($addHouse){
            $res['code'] = 1;
            $res['msg'] = '修改成功！';
            $res['h_id'] = $addHouse;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '修改失败！';
        return json($res);
    }
}