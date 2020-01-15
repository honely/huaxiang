<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/6
 * Time: 10:03
 */
namespace app\xcx\controller;
use think\Controller;
use think\Db;
use think\Request;

class Admin extends Controller{
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

    //管理员
    public function adminData(){
        $where=' 1 = 1 ';
        $keywords = trim($this->request->param('keywords'));
        $ads_role=intval(session('ad_role'));
        if($ads_role == 2){
            $where .= ' and (ad_role = 2 or ad_role = 3)';
        }
        if($ads_role == 35){
            $where .= ' and (ad_role = 32 or ad_role = 33 or ad_role = 39)';
        }
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( ad_realname like '%".$keywords."%' or ad_bid like '%".$keywords."%' )";
        }
        $count=Db::table('super_admin')
            ->join('super_role','super_role.r_id = super_admin.ad_role')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $admin=Db::table('super_admin')
            ->join('super_role','super_role.r_id = super_admin.ad_role')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('ad_id desc')
            ->select();
        foreach($admin as $k => $v){

            $admin[$k]['ad_sex'] = $v['ad_sex']== 1 ? '男' :'女';
        }
        foreach($admin as $k => $v){
            $admin[$k]['ad_realname'] = $v['ad_realname']."    ( ".$v['ad_sex']." )";
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $admin;
        $res['count'] = $count;
        return json($res);
    }



    public function admin(){
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $where = ' 1 = 1 ';
            $keywords=trim($this->request->param('keywords'));
            $ad_role=intval(trim($this->request->param('ad_role')));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( ad_realname like '%".$keywords."%' or ad_phone like '%".$keywords."%' or ad_email like '%".$keywords."%')";
            }
            if(isset($ad_role) && !empty($ad_role)){
                $where.=" and ad_role = ".$ad_role;
            }
            //已展示
            $data['display']=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->where($where)
                ->where(['ad_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->where($where)
                ->where(['ad_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        $wheres = ' 1 = 1 ';
        $roleInfo=Db::table('super_role')->where($wheres)->field('r_id,r_name')->select();
        $this->assign('roleInfo',$roleInfo);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }

    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['ad_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['ad_isable'] = '1';
            }else{
                $msg = '隐藏';
                $data['ad_isable'] = '2';
            }
            $changeStatus = Db::table('super_admin')->where(['ad_id' => $ba_id])->update($data);
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



    //添加管理员
    public function add(){
        $ad_role = intval(session('ad_role'));
        if($_POST){
            $data['ad_bid'] = $_POST['ad_bid'];
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = $_POST['ad_phone'];
            $isRepeat=Db::table('super_admin')
                ->where(['ad_bid' => $data['ad_bid']])
                ->find();
            if($isRepeat){
                $this->error('此工号已注册！','add');
            }
            $data['ad_email'] = $_POST['ad_email'];
            $data['ad_isable'] = $_POST['ad_isable'];
            $data['ad_role'] = $_POST['ad_role'];
            $data['ad_createtime'] = time();
            $data['ad_admin'] = session('adminId');
            $data['ad_password'] = md5('123456');
            $add=Db::table('super_admin')->insert($data);
            if($add){
                $this->success('添加管理员成功','admin');
            }else{
                $this->error('添加管理员失败','admin');
            }
        }else{
            if($ad_role == 2){
                $where = 'r_id = 3';
            }else if($ad_role == 35){
                $where = 'r_id = 32 or r_id = 33 or r_id = 39';
            }else{
                $where = '1 = 1';
            }
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $this->assign('role',$roleInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    //修改管理员
    public function edit(){
        $ad_id=intval($_GET['ad_id']);
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = $_POST['ad_phone'];
            $data['ad_bid'] = $_POST['ad_bid'];
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_bid' => $data['ad_bid']])
                ->find();
            if($isRepeat){
                $this->error('此工号已注册！','admin');
            }
            $data['ad_role'] = $_POST['ad_role'];
            $data['ad_email'] = $_POST['ad_email'];
            $edit=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($edit){
                $this->success('修改管理员成功！','admin');
            }else{
                $this->error('您未做任何修改！','admin');
            }
        }else{
            $ad_role = intval(session('ad_role'));
            $adminInfo=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->field('super_admin.*,super_role.r_name')
                ->where(['ad_id' => $ad_id])
                ->find();
            if($ad_role == 2){
                $where = 'r_id = 3';
            }else if($ad_role == 35){
                $where = 'r_id = 32 or r_id = 33 or r_id = 39';
            }else{
                $where = '1 = 1';
            }
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $this->assign('role',$roleInfo);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }



    //检测电话号码
    public function checkPhone(){
        $ad_id=$_POST['ad_id'];
        $ad_phone=$_POST['ad_bid'];
        if($ad_id){
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_bid' => $ad_phone])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此工号已注册！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此工号经系统检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_admin')->where(['ad_bid' => $ad_phone])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此工号已注册！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此工号经系统检测可用。';
            }
        }
        return $res;
    }



    //检测邮箱
    public function checkEmail(){
        $ad_id=$_POST['ad_id'];
        $ad_email=$_POST['ad_email'];
        if($ad_id){
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_email' => $ad_email])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此邮箱已注册！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此邮箱经系统检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_admin')->where(['ad_email' => $ad_email])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此邮箱已注册！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此邮箱经系统检测可用。';
            }
        }
        return $res;
    }














    //删除管理员
    public function del(){
        $ad_id=intval($_GET['ad_id']);
        $del=Db::table('super_admin')->where(['ad_id' => $ad_id])->delete();
        if($del){
            $this->success('删除管理员成功','admin');
        }else{
            $this->error('删除管理员失败','admin');
        }
    }

    //根据城市id获取
    public function getAreaName(){
        $c_id=intval($_GET['c_id']);
        $branch=Db::table('super_area')
            ->where(['area_c_id' => $c_id])
            ->field('area_id,area_name')
            ->select();
        if($branch){
            return  json(['code' => '1','data' => $branch]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }

    //根据分站id获取该分站下的管理员；
    public function getAdminName(){
        $b_id=intval($_POST['b_id']);
        $admin=Db::table('super_admin')
            ->where(['ad_branch' => $b_id])
            ->field('ad_id,ad_realname')
            ->select();
        if($admin){
            return  json(['code' => '1','data' => $admin]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }





    //角色配置
    public function role(){
        $count=Db::table('super_role')
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $role=Db::table('super_role')
            ->limit(($page-1)*$limit,$limit)
            ->order('r_id desc')
            ->select();
        foreach($role as $k =>$v){
            $role[$k]['countNum']=Db::table('super_admin')->where(['ad_role' => $v['r_id']])->count();
        }
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        $this->assign('role',$role);
        return $this->fetch();
    }



    public  function  addRole(){
        if($_POST){
        }else{
            //顶级菜单
            $menuList=Db::table('super_menu')
                ->where(['m_fid' => '0', 'm_type' => '1'])
                ->order('m_sort desc')
                ->select();
            foreach ($menuList as $k =>$v){
                //子菜单
                $menuList[$k]['child'] = Db::table('super_menu')
                    ->where(['m_fid' => $v['m_id'], 'm_type' => '1'])
                    ->order('m_sort desc')
                    ->select();
                //操作方法；
                foreach($menuList[$k]['child'] as $key =>$val){
                    $menuList[$k]['child'][$key]['children']= Db::table('super_menu')
                        ->where(['m_fid' => $val['m_id'], 'm_type' => '2'])
                        ->order('m_sort desc')
                        ->select();
                }
            }
            $this->assign('menuList',$menuList);
            return $this->fetch();
        }
    }



    //添加角色取到m_ids
    public function addmenuids(){
        $stime=strtotime(date('Y-m-d 00:00:00'));
        $etime=strtotime(date('Y-m-d 23:59:59'));
        //获取当日预约的数量
        $buNum=Db::table('super_role')->where('r_opeatime','between',[$stime,$etime])->count();
        //生成用户编号；
        $data['r_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
        $data['r_power']=trim($_POST['ids'],',');
        $data['r_name']=trim($_POST['r_name']);
        $ids=explode(',',$data['r_power']);
        $data['r_power']=implode(',',array_unique($ids));
        $addRole=Db::table('super_role')->insert($data);
        if($addRole){
            $this->success('添加角色成功','role');
        }else{
            $this->error('添加角色失败','role');
        }
    }


    //editRole
    public function editRole(){
        $r_id=intval($_GET['r_id']);
        if($_POST){
        }else{
            $roleInfo=Db::table('super_role')->where(['r_id' => $r_id])->find();
            $m_ids = "";
            if($roleInfo['r_power']){
                $m_ids = explode(',',trim($roleInfo['r_power'],','));
            }
            //顶级菜单
            $menuList=Db::table('super_menu')
                ->where(['m_fid' => '0', 'm_type' => '1'])
                ->order('m_sort desc')
                ->select();
            foreach ($menuList as $k =>$v){
                //子菜单
                $menuList[$k]['child'] = Db::table('super_menu')
                    ->where(['m_fid' => $v['m_id'], 'm_type' => '1'])
                    ->order('m_sort desc')
                    ->select();
                //操作方法；
                foreach($menuList[$k]['child'] as $key =>$val){
                    $menuList[$k]['child'][$key]['children']= Db::table('super_menu')
                        ->where(['m_fid' => $val['m_id'], 'm_type' => '2'])
                        ->order('m_sort desc')
                        ->select();
                }
            }
            $this->assign('menuList',$menuList);
            $this->assign('m_ids',$m_ids);
            $this->assign('roleInfo',$roleInfo);
            return $this->fetch();
        }
    }


    //editmenuids
    public function editmenuids(){
        $r_id=intval(trim($_POST['r_id']));
        $data['r_power']=trim($_POST['ids'],',');
        $data['r_name']=trim($_POST['r_name']);
        $ids=explode(',',$data['r_power']);
        $data['r_power']=implode(',',array_unique($ids));
        $edit=Db::table('super_role')->where(['r_id' => $r_id])->update($data);
        if($edit){
            $this->success('修改角色成功','role');
        }else{
            $this->error('修改角色失败','role');
        }
    }

    //delrole
    public function delrole(){
        $r_id=intval($_GET['r_id']);
        $del=Db::table('super_role')->where(['r_id' => $r_id])->delete();
        if($del){
            $this->success('删除角色成功','role');
        }else{
            $this->error('删除角色失败','role');
        }
    }




    //菜单列表
    public  function menu(){
        //父级id
        $m_fid = "0";
        if(isset($_GET['m_id'])){
            $m_fid=intval($_GET['m_id']);
        }
        //查看他是否为顶级菜单
        $isTopMenu=Db::table('super_menu')->where(['m_id' => $m_fid])->find();
        $istop=$isTopMenu['m_fid'];
        if($istop == 0 ){
            $where=" m_fid = ".$m_fid." and m_type = 1 ";
//            $where=" m_fid = ".$m_fid;
        }else{
            $where=" m_fid = ".$m_fid." and m_type = 2 ";
//            $where=" m_fid = ".$m_fid;
        }
        $count=Db::table('super_menu')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',20,'intval');
        $menuList=Db::table('super_menu')
            ->where($where)
//            ->fetchSql(true)
            ->order('m_sort desc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        foreach ($menuList as $k =>$v){
            $menuList[$k]['child'] = Db::table('super_menu')->where(['m_fid' => $v['m_id'], 'm_type' => '1'])->select();
            $menuList[$k]['m_type'] = $v['m_type'] == 1 ? "菜单" : "操作";
        }
        $this->assign('m_fid',$m_fid);
        $this->assign('menuList',$menuList);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        return  $this->fetch();
    }


    //添加菜单
    public function addmenu(){
        if($_POST){
            $data['m_name']=$_POST['m_name'];
            $data['m_fid']=$_POST['m_fid'];
            $data['m_type']=$_POST['m_type'];
            $data['m_control']=$_POST['m_control'];
            $data['m_action']=$_POST['m_action'];
            $data['m_icon']=$_POST['m_icon'];
            $data['m_sort']=$_POST['m_sort'];
            $addMenu=Db::table('super_menu')->insert($data);
            if($addMenu){
                $this->success('添加菜单成功！','menu');
            }else{
                $this->error('添加菜单失败！','menu');
            }
        }else{
            if(isset($_GET)){
                $m_fid=intval($_GET['m_fid']);
                if($m_fid){//非顶级菜单
                    $finfo=Db::table("super_menu")->where("m_id=".$m_fid)->find();
                    $this->assign('finfo',$finfo);
                }else{//顶部菜单
                    $this->assign('finfo',array("m_id"=>0,"m_fid"=>0,"m_name"=>'顶级菜单'));
                }
                return $this->fetch();
            }
        }
    }




    //修改菜单
    public function editmenu(){
        if(isset($_GET['m_id'])){
            $m_id=$_GET['m_id'];
            if($_POST){
                $data['m_name']=$_POST['m_name'];
                $data['m_fid']=$_POST['m_fid'];
                $data['m_type']=$_POST['m_type'];
                $data['m_control']=$_POST['m_control'];
                $data['m_action']=$_POST['m_action'];
                $data['m_icon']=$_POST['m_icon'];
                $data['m_sort']=$_POST['m_sort'];
                $editMenu=Db::table('super_menu')->where(['m_id' => $m_id])->update($data);
                if($editMenu){
                    $this->success('修改菜单成功！','menu');
                }else{
                    $this->error('修改菜单失败！','menu');
                }
            }else{
                if(isset($_GET)){
                    $m_fid=intval($_GET['m_fid']);
                    if($m_fid){//非顶级菜单
                        $finfo=Db::table("super_menu")->where(['m_id' => $m_fid])->find();
                        $menuInfo=Db::table('super_menu')->where(['m_id' => $m_id])->find();
                        $this->assign('finfo',$finfo);
                        $this->assign('menu',$menuInfo);
                    }else{//顶部菜单
                        $menuInfo=Db::table('super_menu')->where(['m_id' => $m_id])->find();
                        $this->assign('finfo',array("m_id"=>0,"m_fid"=>0,"m_name"=>'顶级菜单'));
                        $this->assign('menu',$menuInfo);
                    }
                    return $this->fetch();
                }
            }
        }
    }


    //删除某个菜单
    public function delmenu(){
        $m_id=$_GET['m_id'];
        $isChild=Db::table('super_menu')->where(['m_fid' => $m_id])->find();
        if($isChild){
            $this->error('此菜单下有子菜单或操作，不能删除！','menu');
        }else{
            $del=Db::table('super_menu')->where(['m_id' => $m_id])->delete();
            if($del){
                $this->success('删除成功！','menu');
            }else{
                $this->error('删除失败！','menu');
            }
        }
    }

}