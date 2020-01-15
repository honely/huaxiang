<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/22
 * Time: 11:32
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Department extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
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
    /*
     * 部门管理
     * */
    public function index(){
        //父级id
        $m_fid = "0";
        if(isset($_GET['d_id'])){
            $m_fid=intval($_GET['d_id']);
        }
        //查看他是否为顶级菜单
        $isTopMenu=Db::table('super_department')->where(['d_id' => $m_fid])->find();
        $istop=$isTopMenu['d_id'];
        if($istop == 0 ){
            $where=" d_f_id = ".$m_fid;
        }else{
            $where=" d_f_id = ".$m_fid;
        }
        $count=Db::table('super_department')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $menuList=Db::table('super_department')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        foreach($menuList as $k => $v){
            $menuList[$k]['d_addtime'] =date('Y-m-d H:i:s',$v['d_addtime']);
        }
        $this->assign('m_fid',$m_fid);
        $this->assign('menuList',$menuList);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        return  $this->fetch();
    }

    /*
     * add
     * */
    public function add(){
        if($_POST){
            $data['d_name']=$_POST['d_name'];
            $data['d_f_id']=$_POST['d_f_id'];
            $data['d_addtime']=time();
            $addMenu=Db::table('super_department')->insert($data);
            if($addMenu){
                $this->success('添加部门成功！','index');
            }else{
                $this->error('添加部门失败！','index');
            }
        }else{
            if(isset($_GET)){
                $m_fid=intval($_GET['d_f_id']);
                if($m_fid){//非顶级菜单
                    $finfo=Db::table("super_department")->where("d_id=".$m_fid)->find();
                    $this->assign('finfo',$finfo);
                }else{//顶部菜单
                    $this->assign('finfo',array("d_id"=>0,"d_f_id"=>0,"d_name"=>'顶级部门'));
                }
                return $this->fetch();
            }
        }
    }

    public function edit(){
        if(isset($_GET['d_id'])){
            $m_id=$_GET['d_id'];
            if($_POST){
                $data['d_name']=$_POST['d_name'];
                $editMenu=Db::table('super_department')->where(['d_id' => $m_id])->update($data);
                if($editMenu){
                    $this->success('修改菜单成功！','index');
                }else{
                    $this->error('修改菜单失败！','index');
                }
            }else{
                if(isset($_GET)){
                    $m_fid=intval($_GET['d_f_id']);
                    if($m_fid){//非顶级菜单
                        $finfo=Db::table("super_department")->where(['d_id' => $m_fid])->find();
                        $menuInfo=Db::table('super_department')->where(['d_id' => $m_id])->find();
//                        dump($menuInfo);
//                        dump($finfo);
                        $this->assign('finfo',$finfo);
                        $this->assign('menu',$menuInfo);
                    }else{//顶部菜单
                        $menuInfo=Db::table('super_department')->where(['d_id' => $m_id])->find();
//                        dump($menuInfo);
//                        dump(array("d_id"=>0,"d_f_id"=>0,"d_name"=>'顶级部门'));
                        $this->assign('finfo',array("d_id"=>0,"d_f_id"=>0,"d_name"=>'顶级部门'));
                        $this->assign('menu',$menuInfo);
                    }
                    return $this->fetch();
                }
            }
        }
    }
}