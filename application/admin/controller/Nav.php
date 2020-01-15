<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/28
 * Time: 9:19
 * Name: 导航管理： 1.列表；2.添加导航；3.修改；4.删除；5.禁用；6.条件查找。
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Nav extends Controller{
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
    //导航列表
    public function navData(){

        $count = Db::table('super_nav')
            ->join('super_admin','super_nav.nav_admin = super_admin.ad_id')
            ->count();
        $nav=Db::table('super_nav')
            ->join('super_admin','super_nav.nav_admin = super_admin.ad_id')
            ->order('nav_order desc')
            ->select();
        foreach ($nav as $k => $v){
            $nav[$k]['nav_opeatime'] = date('Y-m-d H:i:s',$v['nav_opeatime']);
        }
        $this->assign('nav',$nav);
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $nav;
        $res['count'] = $count;
        return json($res);
    }

    public function navlist(){
        $navList=Db::table('super_nav')
            ->where(['nav_fid' => 0])
            ->join('super_admin','super_nav.nav_admin = super_admin.ad_id')
            ->order('nav_order desc')
            ->select();
        foreach($navList as $k =>$v){
            $navList[$k]['subNav']=Db::table('super_nav')
                ->join('super_admin','super_nav.nav_admin = super_admin.ad_id')
                ->where(['nav_fid' => $v['nav_id']])
                ->order('nav_order desc')
                ->select();
        }
        $this->assign('navList',$navList);
        return $this->fetch();
    }

    public function navlist2(){
        //父级id
        $m_fid = "0";
        if(isset($_GET['nav_id'])){
            $m_fid=intval($_GET['nav_id']);
        }
        //查看他是否为顶级菜单
        $isTopMenu=Db::table('super_nav')->where(['nav_fid' => $m_fid])->find();
        $istop=$isTopMenu['nav_fid'];
        if($istop == 0 ){
            $where=" nav_fid = ".$m_fid."";
        }else{
            $where=" nav_fid = ".$m_fid." ";
        }
        $count=Db::table('super_nav')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $navList=Db::table('super_nav')
            ->join('super_admin','super_nav.nav_admin = super_admin.ad_id')
            ->where($where)
            ->order('nav_order desc')
            ->limit(($page-1)*$limit,$limit)
            ->field('super_nav.*,super_admin.ad_realname')
            ->select();
        foreach ($navList as $k =>$v){
            $navList[$k]['fName']=$v['nav_fid']== 0 ? "一级导航":"二级导航";
            $navList[$k]['nav_isable']=$v['nav_isable']== 1 ? "显示":"隐藏";
            $navList[$k]['subNav'] = Db::table('super_nav')->where(['nav_fid' => $v['nav_id'], 'nav_isable' => '1'])->select();
        }
        $this->assign('nav_fid',$m_fid);
        $this->assign('navList',$navList);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        return  $this->fetch();
    }





    public function navList1(){
        return $this->fetch();
    }

    //更改是否显示的状态
    public function status(){
        $ba_id = $_POST['nav_id'];
        $change = $_POST['change'];
        if($ba_id && isset($change)){
            if($change){
                $msg = '显示';
                $data['nav_isable'] = '1';
            }else{
                $msg = '隐藏';
                $data['nav_isable'] = '2';
            }
            $changeStatus = Db::table('super_nav')->where(['nav_id' => $ba_id])->update($data);
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


    //reOrder
    //修改排序
    public function reOrder(){
        $nav_id=$_POST['nav_id'];
        $nav_order=intval(trim($_POST['value']));
        if(!empty($nav_order)){
            $reOrder=Db::table('super_nav')->where(['nav_id' => $nav_id])->update(['nav_order' => $nav_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }










    //添加导航
    public function add(){
        if($_POST){
            $data['nav_title'] = $_POST['nav_title'];
            $data['nav_fid'] = $_POST['nav_fid'];
            $data['nav_seo_title'] = $_POST['nav_seo_title'];
            $data['nav_seo_keywords'] = $_POST['nav_seo_keywords'];
            $data['nav_seo_desc'] = $_POST['nav_seo_desc'];
            $data['nav_order'] = $_POST['nav_order'];
            $data['nav_url'] = $_POST['nav_url'];
            $data['nav_img'] = isset($_POST['nav_img'])?$_POST['nav_img']:'';
            $data['nav_hover_img'] = isset($_POST['nav_hover_img'])?$_POST['nav_hover_img']:'';
            $data['nav_isable'] = $_POST['nav_isable'];
            $data['nav_admin'] = session('adminId');
            $data['nav_opeatime'] = time();
            $add=Db::table('super_nav')->insert($data);
            if($add){
                $this->success('添加导航成功','navlist');
            }else{
                $this->error('添加导航失败','navlist');
            }
        }else{
            $fNav=Db::table('super_nav')
                ->where(['nav_isable' => 1,'nav_fid' => 0])
                ->field('nav_id,nav_title')
                ->order('nav_order desc')
                ->select();
            $this->assign('fNav',$fNav);
            return $this->fetch();
        }
    }

    //修改导航

    public function edit(){
        $nav_id=intval($_GET['nav_id']);
        $nav_fid=intval($_GET['nav_fid']);
        if($_POST){
            $data['nav_title'] = $_POST['nav_title'];
            $data['nav_seo_title'] = $_POST['nav_seo_title'];
            $data['nav_seo_keywords'] = $_POST['nav_seo_keywords'];
            $data['nav_seo_desc'] = $_POST['nav_seo_desc'];
            $data['nav_order'] = $_POST['nav_order'];
            $data['nav_img'] = isset($_POST['nav_img'])?$_POST['nav_img']:'';
            $data['nav_hover_img'] = isset($_POST['nav_hover_img'])?$_POST['nav_hover_img']:'';
            $data['nav_url'] = $_POST['nav_url'];
            $data['nav_isable'] = $_POST['nav_isable'];
            $data['nav_admin'] = session('adminId');
            $data['nav_opeatime'] = time();
            $edit=Db::table('super_nav')->where(['nav_id' => $nav_id])->update($data);
            if($edit){
                $this->success('修改导航成功！','navlist');
            }else{
                $this->error('修改导航失败！','navlist');
            }
        }else{
            $navInfo=Db::table('super_nav')->where(['nav_id' => $nav_id])->find();
            $this->assign('nav_fid',$nav_fid);
            $this->assign('nav',$navInfo);
            $nav_f_info=Db::table('super_nav')->where(['nav_id' => $nav_fid])->find();
            $this->assign('f_name',$nav_f_info['nav_title']);
            return $this->fetch();
        }
    }


    //删除导航
    public function del(){
        $nav_id=intval($_GET['nav_id']);
        $del=Db::table('super_nav')->where(['nav_id' => $nav_id])->delete();
        if($del){
            $this->success('删除成功','navlist');
        }else{
            $this->error('删除失败','navlist');
        }
    }



    //图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/nav');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/nav/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }
}