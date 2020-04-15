<?php
namespace app\xcx\controller;
use think\Controller;
use think\Db;
use think\Request;

class Question extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminId');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }


    public function rent1(){
        return $this->fetch();
    }


    public function loard1(){
        return $this->fetch();
    }

    public function rentData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type)){
            $where.=" and type = '".$type."'";
        }
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        $count=Db::table('tk_questions')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('tk_questions')
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

}