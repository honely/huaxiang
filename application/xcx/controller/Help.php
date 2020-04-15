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
    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '回访';
                $data['h_is_review'] = 1;
            }else{
                $msg = '取消回访';
                $data['h_is_review'] = 2;
            }
            $changeStatus = Db::table('xcx_helpme')->where(['h_id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
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
            if($help){
                $help['h_price_min'] = $help['h_price_min'].'---'.$help['h_price_max'];
            }
            $this->assign('help',$help);
            return $this->fetch();
        }
    }
}