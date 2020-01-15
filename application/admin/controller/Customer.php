<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/19
 * Time: 10:09
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Customer extends Controller{

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

    /*
     * 会员管理
     * */
    public function index(){
        return $this->fetch();
    }

    /*
     *
     * custData
     * */
    public function custData(){
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        $where='1 = 1';
        $keywords=trim($this->request->param('keywords'));
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $sys_id=intval(trim($this->request->param('sys_id')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $cus_opptime=$this->request->param('cus_opptime');


        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and cus_provid = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and cus_cityid = ".$bu_c_id;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and cus_opeater = ".$case_admin;
        }
        if(isset($sys_id) && !empty($sys_id) && $sys_id){
            $where.=" and cus_sys = ".$sys_id;
        }
        if(isset($cus_opptime) && !empty($cus_opptime)){
            $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
            $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
            $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
        }
        //分页统计总数；
        $count=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cus_id desc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['c_name']=$v['p_name']."-".$v['c_name']."-".$v['b_name'];
            $cusInfo[$k]['cus_from']=$v['cus_from']."&nbsp;&nbsp;".$v['cus_origin'];
            $cusInfo[$k]['cus_link']=$v['cus_device']."&nbsp;&nbsp;".$v['cus_position']."<br/>".$v['cus_link'];
            $cusInfo[$k]['cus_opptime']=date('Y-m-d H:i:s',$v['cus_opptime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['cus_opeater']) && is_int($v['cus_opeater'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['cus_opeater']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['ad_realname']= $adName;
            //操作时间
            if(!empty($v['cus_backtime']) && is_int($v['cus_backtime'])){
                $backtime = date('Y-m-d H:i:s',$v['cus_backtime']);
            }else{
                $backtime = "暂未回访";
            }
            $cusInfo[$k]['cus_backtime']= $backtime;
            if($ad_role == 12){
                $cusInfo[$k]['cus_phone'] = substr_replace($v['cus_phone'],'****',3,4);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }

    /*
     * 营销管理
     * */
    public function conpon(){
        return $this->fetch();
    }


    /*
     * conponData
     * */
    public function conponData(){
        $where = " 1 = 1";
        $count=Db::table('super_coupon')
            ->join('super_admin','super_admin.ad_id = super_coupon.cp_admin')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $coupon=Db::table('super_coupon')
            ->join('super_admin','super_admin.ad_id = super_coupon.cp_admin')
            ->limit(($page-1)*$limit,$limit)
            ->where($where)
            ->order('cp_addtime desc')
            ->select();
        foreach ($coupon as $k =>$v){
            $coupon[$k]['cp_deadline'] = date('Y-m-d',$v['cp_deadline']);
            $coupon[$k]['cp_addtime'] = date('Y-m-d',$v['cp_addtime']);
        }
        $res['code'] = 0;
        $res['data'] = $coupon;
        $res['count'] = $count;
        return json($res);
    }

    public function addconpon(){
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_coupon')->where('cp_addtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data=$_POST;
            $data['cp_deadline']=strtotime($_POST['cp_deadline']);
            $data['cp_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['cp_addtime'] =time();
            $data['cp_admin'] = session('adminId');
            $data['cp_isable'] =1;
            $add=Db::table('super_coupon')->insert($data);
            if($add){
                $this->success('发布成功！','conpon');
            }else{
                $this->error('发布失败！','conpon');
            }
        }else{
            $adminId=session('adminId');
            $ad_role=intval(session('ad_role'));
            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_coupon')->select();
                $this->assign('prov',$provInfo);
            }else{
                $adminInfo=Db::table('super_coupon')
                    ->join('super_province','super_province.p_id = super_admin.ad_p_id')
                    ->field('super_admin.ad_realname,super_role.r_name')
                    ->where(['ad_id' => $adminId])
                    ->find();
                $this->assign('admin',$adminInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }



    /*
     * delconpon
     * */
    public function delconpon(){
        $cp_id=intval(trim($_GET['cp_id']));
        $del=Db::table('super_coupon')->where(['cp_id' => $cp_id])->delete();
        if($del){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }



    //更改是否显示的状态
    public function status(){
        $cp_id = intval($_GET['cp_id']);
        $change = intval($_GET['change']);
        if($cp_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['cp_isable'] = '1';
                $data['cp_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['cp_isable'] = '2';
                $data['cp_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_coupon')->where(['cp_id' => $cp_id])->update($data);
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



    public function editconpon(){
        $cp_id=intval(trim($_GET['cp_id']));
        if($_POST){
            $data=$_POST;
            $data['cp_deadline']=strtotime($_POST['cp_deadline']);
            $data['cp_addtime'] =time();
            $data['cp_admin'] = session('adminId');
            $update=Db::table('super_coupon')->where(['cp_id' => $cp_id])->update($data);
            if($update){
                $this->success('更新成功！','conpon');
            }else{
                $this->error('更新失败！','conpon');
            }
        }else{
            $conpon=Db::table('super_coupon')->where(['cp_id' => $cp_id])->find();
            $conpon['cp_deadline']=date('Y-m-d',$conpon['cp_deadline']);
            $this->assign('conpon',$conpon);
            return $this->fetch();
        }
    }

}