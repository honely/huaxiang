<?php


namespace app\xcx\controller;


use think\Controller;
use think\Db;

class Mate extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function indexData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( cdate >= ".$sdate." and cdate <= ".$edate." ) ";
        }
        $count=Db::table('tk_roommates')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('tk_roommates')
            ->limit(($page-1)*$limit,$limit)
            ->order('id desc')
            ->where($where)
            ->select();
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }

    public function search(){
        
    }

}