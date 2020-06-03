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
        $ad_role = intval(session('ad_role'));
        $adminInfo=Db::table('super_admin')
            ->where(['ad_id' => $ad_id])
            ->find();
        $allrole = [
            [
                'ad_id' => '1',
                'ad_role' => '超级管理员',
                'is_checked' => false
            ],
            [
                'ad_id' => '43',
                'ad_role' => '企业负责人',
                'is_checked' => false
            ],
            [
                'ad_id' => '44',
                'ad_role' => '企业员工',
                'is_checked' => false
            ],
            [
                'ad_id' => '45',
                'ad_role' => '运营负责人',
                'is_checked' => false
            ],
            [
                'ad_id' => '46',
                'ad_role' => '客服',
                'is_checked' => false
            ]
        ];
        $houseBill = explode(',',$adminInfo['ad_role']);
        foreach ($allrole as $key => &$val) {
            if(in_array($val['ad_id'], $houseBill)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['sub'] = $houseBill;
        $where = '1 = 1';
        $roleInfo=Db::table('super_role')
            ->field('r_id,r_name')
            ->where($where)
            ->select();
        $adminUser = Db::table('tk_user')
            ->where(['role_id' => 1])
            ->field('id,nickname,tel')
            ->select();
        $this->assign('allrole',$allrole);
        $this->assign('user',$adminUser);
        $this->assign('role',$roleInfo);
        $this->assign('admin',$adminInfo);
        return $this->fetch();
    }

    public function edit(){
        $ad_id =session('adminId');
        if($_POST){
            $data['ad_realname'] = $_POST['ad_realname'];
            $data['ad_sex'] = $_POST['ad_sex'];
            $data['ad_phone'] = $_POST['ad_phone'];
            $data['ad_bid'] = $_POST['ad_bid'];
            $data['ad_corp'] = $_POST['ad_corp'];
            $data['ad_weixin'] = $_POST['ad_weixin'];
            $data['ad_job'] = $_POST['ad_job'];
            $data['ad_img'] = $_POST['ad_img'];
            $data['ad_desc'] = $_POST['ad_desc'];
            if(isset($_POST['ad_role']) && $_POST['ad_role']){
                $bill = $_POST['ad_role'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['ad_role'] = rtrim($bills,',');
            }
            $data['ad_email'] = $_POST['ad_email'];
            $edit=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($edit){
                $this->success('修改成功！','personal');
            }else{
                $this->error('您未做任何修改！','personal');
            }
        }else{
            $adminInfo=Db::table('super_admin')
                ->where(['ad_id' => $ad_id])
                ->find();
            $allrole = [
                [
                    'ad_id' => '1',
                    'ad_role' => '超级管理员',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '43',
                    'ad_role' => '企业负责人',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '44',
                    'ad_role' => '企业员工',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '45',
                    'ad_role' => '运营负责人',
                    'is_checked' => false
                ],
                [
                    'ad_id' => '46',
                    'ad_role' => '客服',
                    'is_checked' => false
                ]
            ];
            $houseBill = explode(',',$adminInfo['ad_role']);
            foreach ($allrole as $key => &$val) {
                if(in_array($val['ad_id'], $houseBill)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $houseInfo['sub'] = $houseBill;
            $where = '1 = 1';
            $roleInfo=Db::table('super_role')
                ->field('r_id,r_name')
                ->where($where)
                ->select();
            $adminUser = Db::table('tk_user')
                ->where(['role_id' => 1])
                ->field('id,nickname,tel')
                ->select();
            $this->assign('allrole',$allrole);
            $this->assign('user',$adminUser);
            $this->assign('role',$roleInfo);
            $this->assign('admin',$adminInfo);
            return $this->fetch();
        }
    }


    public function bindemail(){
        return $this->fetch();

    }
    public function bindphone(){
        return $this->fetch();

    }
}