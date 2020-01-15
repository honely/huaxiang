<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/22
 * Time: 14:04
 */
namespace app\admin\controller;
use app\marketm\controller\Common;
use think\Controller;
use think\Db;
use think\Request;

class Staff extends Controller{
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

    public function index(){
        $where="1 = 1";
        $staff=Db::table('super_user')->where($where)->select();
        $this->assign('staff',$staff);
        return $this->fetch();
    }

    public function staffData(){
        $where=' 1 = 1 ';
        $keywords=trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( u_name like '%".$keywords."%' or u_phone like '%".$keywords."%'  or u_job like '%".$keywords."%' )";
        }
        $count=Db::table('super_user')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $admin=Db::table('super_user')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('u_addtime desc')
            ->select();
        $commonModel=new Common();
        if($admin){
            foreach ($admin as $key => $val){
                $admin[$key]['u_c_id'] =$commonModel->getCitynameByCityId($val['u_c_id']);
                $admin[$key]['u_depart_id'] =$commonModel->getDepartNameByDepartId($val['u_depart_id']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $admin;
        $res['count'] = $count;
        return json($res);
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['u_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '修改';
                $data['u_isable'] = '1';
            }else{
                $msg = '修改';
                $data['u_isable'] = '2';
            }
            $changeStatus = Db::table('super_user')->where(['u_id' => $ba_id])->update($data);
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
        if($_POST){
            $data['u_name'] = $_POST['u_name'];
            $data['u_job'] = $_POST['u_job'];
            $data['u_c_id'] = $_POST['u_c_id'];
            $data['u_sex'] = $_POST['u_sex'];
            $data['u_phone'] = $_POST['u_phone'];
            $data['u_depart_id'] = intval(trim($_POST['u_depart_id']));
            $data['u_addtime'] = time();
            $data['u_isable'] = 1;
            $data['u_password'] = md5('123456');
            $isRepeat=Db::table('super_user')
                ->where(['u_phone' => $data['u_phone']])
                ->find();
            if($isRepeat){
                $this->error('此手机号已注册！','add');
            }
            $data['u_email'] = $_POST['u_email'];
            $isRepeat=Db::table('super_user')
                ->where(['u_email' => $data['u_email']])
                ->find();
            if($isRepeat){
                $this->error('此邮箱已注册！','add');
            }
            $add=Db::table('super_user')->insert($data);
            if($add){
                $this->success('添加员工成功','index');
            }else{
                $this->error('添加员工失败','index');
            }
        }else{
            $indexModel=new \app\common\controller\Index();
            $city=$indexModel->getCityName();
            $this->assign('city',$city);
            $department=Db::table('super_department')
                ->order('d_addtime desc')
                ->select();
            $this->assign('department',$department);
            return $this->fetch();
        }
    }



    //检测电话号码
    public function checkPhone(){
        $ad_id=$_POST['u_id'];
        $ad_phone=$_POST['u_phone'];
        if($ad_id){
            $isRepeat=Db::table('super_user')
                ->where('u_id','neq',$ad_id)
                ->where(['u_phone' => $ad_phone])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此手机号已注册！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此手机号经系统检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_user')->where(['u_phone' => $ad_phone])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此手机号已注册！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此手机号经系统检测可用。';
            }
        }
        return $res;
    }



    //检测邮箱
    public function checkEmail(){
        $ad_id=$_POST['u_id'];
        $ad_email=$_POST['u_email'];
        if($ad_id){
            $isRepeat=Db::table('super_user')
                ->where('u_id','neq',$ad_id)
                ->where(['u_email' => $ad_email])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此邮箱已注册！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此邮箱经系统检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_user')->where(['u_email' => $ad_email])->find();
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
        $ad_id=intval($_GET['u_id']);
        $del=Db::table('super_user')->where(['u_id' => $ad_id])->delete();
        if($del){
            $this->success('删除成功','index');
        }else{
            $this->error('删除失败','index');
        }
    }


    //修改管理员
    public function edit(){
        $ad_id=intval($_GET['u_id']);
        if($_POST){
            $data['u_name'] = $_POST['u_name'];
            $data['u_job'] = $_POST['u_job'];
            $data['u_sex'] = $_POST['u_sex'];
            $data['u_c_id'] = $_POST['u_c_id'];
            $data['u_depart_id'] = intval(trim($_POST['u_depart_id']));
            $data['u_phone'] = $_POST['u_phone'];
            $data['u_addtime'] = time();
            $data['u_isable'] = 1;
            $data['u_password'] = md5('123456');
            $isRepeat=Db::table('super_user')
                ->where('u_id','neq',$ad_id)
                ->where(['u_phone' => $data['u_phone']])
                ->find();
            if($isRepeat){
                $this->error('此手机号已注册！');
            }
            $data['u_email'] = $_POST['u_email'];
            $isRepeat=Db::table('super_user')
                ->where('u_id','neq',$ad_id)
                ->where(['u_email' => $data['u_email']])
                ->find();
            if($isRepeat){
                $this->error('此邮箱已注册！');
            }
            $edit=Db::table('super_user')->where(['u_id' => $ad_id])->update($data);
            if($edit){
                $this->success('修改成功！','index');
            }else{
                $this->error('您未做任何修改！','index');
            }
        }else{
            $adminInfo=Db::table('super_user')
                ->where(['u_id' => $ad_id])
                ->find();
            $indexModel=new \app\common\controller\Index();
            $city=$indexModel->getCityName();
            $this->assign('city',$city);
            $department=Db::table('super_department')
                ->order('d_addtime desc')
                ->select();
            $this->assign('department',$department);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }
}