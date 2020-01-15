<?php


namespace app\oa\controller;


use think\Controller;
use think\Db;

class Hello extends Controller
{


    public function addnew(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        $data['fu_phone'] = $phone;
        $data['fu_addtime'] = time();
        $addNew = Db::table('crm_form_user')->insert($data);
        if($addNew){
            $res['code'] =1;
            $res['msg'] ='提交成功！';
            return json($res);
        }else{
            $res['code'] =2;
            $res['msg'] ='提交失败';
            return json($res);
        }
    }

    public function text(){
        $days['aDay'] = date('Y-m-d H:i:s',strtotime('1 days'));
        $days['twoDays'] = date('Y-m-d H:i:s',strtotime('2 days'));
        dump($days);
        $Aus = $this->getAusDays();
        dump($Aus);
    }

    public function getAusDays(){
        date_default_timezone_set("Australia/Melbourne");
        $days['aDay'] = date('Y-m-d H:i:s',strtotime('1 days'));
        $days['twoDays'] = date('Y-m-d H:i:s',strtotime('2 days'));
        return $days;
    }

}