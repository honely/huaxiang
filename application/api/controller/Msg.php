<?php
namespace app\api\controller;
use app\xcx\model\Msgs;
use think\Controller;

class Msg extends Controller
{

    public function touch(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $ulId = intval(trim($this->request->param('ulid')));
        $msgm = new Msgs();
        $createTouch = $msgm->createTouch($uId,$ulId);
        if($createTouch){
            $res['code'] = 1;
            $res['msg'] = '创建成功！';
            $res['id'] = $createTouch;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '创建失败！';
        $res['id'] = $createTouch;
        return json($res);
    }

}