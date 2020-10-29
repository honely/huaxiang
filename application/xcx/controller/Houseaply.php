<?php

namespace app\xcx\controller;


use app\xcx\model\Languages;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use phpmailer\PHPMailer;
use think\Controller;
use think\Db;
use think\Loader;

class Houseaply extends Controller
{
    public function index(){
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $this->assign('lable',$enLab);
        return $this->fetch();
    }
    public function applyData(){
        $count=Db::table('tk_houseapply')
            ->count('ha_id');
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('tk_houseapply')
            ->limit(($page-1)*$limit,$limit)
            ->order('ha_ctime desc')
            ->select();
        $loop = new Loops();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['ha_status'] = $v['ha_status'] == 1 ? '未联系' : '已联系';
                $example[$k]['ha_uid'] = $loop->getUserNick($v['ha_uid']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }
}