<?php


namespace app\xcx\controller;


use think\Controller;

class Translate extends Controller
{

    public function transto(){
        $querys = $this->request->param('content');
        $regex = "/(\/|\*|\"){2,}/";
        $other = preg_replace($regex,"*", $querys);
        $to = $this->request->param('to');
        $trans = new \app\xcx\model\Translate();
        $res = $trans->translate($other,'auto',$to);
        return $res;
    }

}