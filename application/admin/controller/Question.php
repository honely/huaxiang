<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/10/10
 * Time: 14:04
 * Name: Controller
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Question extends Controller{

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

    public function index(){
        return $this->fetch();
    }

    public function questionData(){
        $where="1 = 1";
        $count=Db::table('super_question')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('super_question')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('q_addtime desc')
            ->select();
        foreach($example as $k => $v ){
            $example[$k]['q_addtime'] = date('Y-m-d H:i:s',$v['q_addtime']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }
}