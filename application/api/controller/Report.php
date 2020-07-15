<?php


namespace app\api\controller;


use app\xcx\model\Reports;
use think\Controller;

class Report extends Controller
{
    public function add(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',0)));
        $mid = intval(trim($this->request->param('mid')));
        $content = trim($this->request->param('content'));
        $userName = trim($this->request->param('uname'));
        $title = trim($this->request->param('title'));
        $type = trim($this->request->param('type','0','intval'));
        $col = new Reports();
        $add = $col->addReport($uId,$mid,$content,$type,$userName,$title);
        if($add){
            $res['code'] = 1;
            $res['msg'] = '举报成功！';
            $res['id'] = $add;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '举报失败！';
        $res['id'] = $add;
        return json($res);
    }

}