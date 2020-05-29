<?php


namespace app\xcx\controller;


use think\Controller;
use think\Db;
use think\Request;

class Account extends Controller
{
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
        $adminId=session('adminId');
        $this->assign('admin_id',$adminId);
        return $this->fetch();
    }

    public function personal(){
        $ad_id =session('adminId');
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = $_POST['ad_phone'];
            $data['ad_bid'] = $_POST['ad_bid'];
            $data['ad_weixin'] = $_POST['ad_weixin'];
            $data['ad_img'] = $_POST['ad_img'];
            $data['ad_desc'] = $_POST['ad_desc'];
            $isRepeat=Db::table('super_admin')
                ->where('ad_id','neq',$ad_id)
                ->where(['ad_bid' => $data['ad_bid']])
                ->find();
            if($isRepeat){
                $this->error('此工号已注册！','admin');
            }
            $data['ad_email'] = $_POST['ad_email'];
            $edit=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($edit){
                $this->success('修改管理员成功！','personal');
            }else{
                $this->error('您未做任何修改！','personal');
            }
        }else{
            $adminInfo=Db::table('super_admin')
                ->join('super_role','super_role.r_id = super_admin.ad_role')
                ->field('super_admin.*,super_role.r_name')
                ->where(['ad_id' => $ad_id])
                ->find();
            $where = '1 = 1';
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $adminUser = Db::table('tk_user')
                ->where(['role_id' => 1])
                ->field('id,nickname,tel')
                ->select();
            $this->assign('user',$adminUser);
            $this->assign('role',$roleInfo);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }
}