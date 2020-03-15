<?php

namespace app\xcx\controller;


use think\Controller;
use think\Db;

class Help extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function helpData(){
        $where ='1 = 1 ';
        $count=Db::table('xcx_helpme')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('xcx_helpme')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('h_addtime desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['h_is_review'] = $v['h_is_review'] == 1 ? '是' : '否';
                $example[$k]['h_admin'] = $this->getAdminName($v['h_admin']);
            }

        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function getAdminName($adId){
        $adimin = Db::table('super_admin')
            ->where(['ad_id' => $adId])
            ->field('ad_bid')
            ->find();
        return $adimin ? $adimin['ad_bid'] : '---';
    }

    public function review(){
        $h_id = $this->request->param('h_id');
        if($_POST){
            $data['h_review'] = $_POST['h_review'];
            $data['h_is_review'] = 1;
            $adminId = session('adminId');
            $data['h_admin'] = $adminId;
            $data['h_review_time'] = date('Y-m-d H:i:s');
            $update = Db::table('xcx_helpme')->where(['h_id' => $h_id])->update($data);
            if($update){
                $this->success('修改成功！');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $help = Db::table('xcx_helpme')->where(['h_id' => $h_id])->find();
            $this->assign('help',$help);
            return $this->fetch();
        }
    }
}