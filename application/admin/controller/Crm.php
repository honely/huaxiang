<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 14:02
 */
namespace app\admin\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class Crm extends Controller{
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
        $roleId = intval(session('ad_role'));
        //服务类型
        $service = Db::table('crm_service')->select();
        //客户状态
        $status = Db::table('crm_user_status')->select();
        $this->assign('roleId',$roleId);
        $this->assign('status',$status);
        $this->assign('service',$service);
        return $this->fetch();
    }

    public function userData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $status = intval(trim($this->request->param('status')));
        $service = intval(trim($this->request->param('service')));
        $live_time=$this->request->param('live_time');
        if($roleId == 1 || $roleId == 2|| $roleId == 37){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and crm_user_admin = ".$adminId;
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( crm_wechat like '%".$keywords."%' or crm_user_bid like '%".$keywords."%' or crm_remarks like '%".$keywords."%')";
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and crm_user_status = ".$status;
        }
        if(isset($service) && !empty($service) && $service){
            $where.=" and crm_service_type = ".$service;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=strtotime(substr($live_time,'0','10')." 00:00:00");
            $edate=strtotime(substr($live_time,'-10')." 23:59:59");
            $where.=" and ( crm_user_addtime >= ".$sdate." and crm_user_addtime <= ".$edate." ) ";
        }
        $count=Db::table('crm_user')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_user')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('crm_user_id desc')
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname,ad_role')->find();
                $adName = $adInfo['ad_realname'];
                $adRole = $adInfo['ad_role'] == $roleId ? 1 :0;
            }else{
                $adName="---";
                $adRole = 0;
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['crm_city']) && is_int($v['crm_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['crm_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['crm_city']= $city;

            if(!empty($v['crm_service_type']) && is_int($v['crm_service_type'])){
                $adInfo=Db::table('crm_service')
                    ->where(['crm_s_id' => $v['crm_service_type']])
                    ->find();
                $service = $adInfo['crm_type'];
            }else{
                $service="---";
            }
            $cusInfo[$k]['crm_service_type']= $service;

            if(!empty($v['crm_user_status']) && is_int($v['crm_user_status'])){
                $adInfo = Db::table('crm_user_status')
                    ->where(['id' => $v['crm_user_status'],'is_able' => 1])
                    ->find();
                $status = $adInfo['status_name'];
            }else{
                $status="---";
            }
            $cusInfo[$k]['crm_user_status']= $status;
            $cusInfo[$k]['crm_is_show']= $adRole;
            $cusInfo[$k]['crm_live_time']= $v['crm_live_time'] ? date('Y-m-d H:i:s',$v['crm_live_time']) : '---';
            $cusInfo[$k]['crm_update_time']= date('Y-m-d H:i:s',$v['crm_update_time']);
            $cusInfo[$k]['is_alert']= $this->isAlert($v['crm_user_id']);
            $day1 = date('Y-m-d',$v['crm_user_addtime']);
            $day2 = substr($v['crm_order_time'],'0','10');
            $cusInfo[$k]['crm_order_circle']= $v['crm_order_time'] == '0000-00-00 00:00:00' ? "---" : $common->diffBetweenTwoDays($day1,$day2).'天';
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    public function isAlert($userId){
        //获取当日预约的数量+月份和日期
        $stime=strtotime(date('Y-m-d 00:00:00'));
        $etime=strtotime(date('Y-m-d 23:59:59'));
        $alerts = Db::table('crm_user_alert')
            ->where(['user_id' => $userId])
            ->order('alert_time desc')
            ->find();
        if($alerts['alert_time'] >= $stime && $alerts['alert_time'] <= $etime){
            return 1;
        }else{
            return 2;
        }
    }




    public function add(){
        $adminId = session('adminId');
        if($_POST){
            $data['crm_wechat'] = $_POST['crm_wechat'];
            $isRepeat=Db::table('crm_user')
                ->where(['crm_wechat' => $data['crm_wechat']])
                ->find();
            if($isRepeat){
                $this->error('此微信号已注册！','add');
            }
            $data['crm_user_admin'] = $adminId;
            $data['crm_user_bid'] = $_POST['crm_user_bid'];
//            $data['crm_sex'] = $_POST['crm_sex'];
            $data['crm_refer'] = $_POST['crm_refer'];
            $data['crm_phone'] = $_POST['crm_phone'];
            $data['crm_city'] = $_POST['crm_city'];
            $data['crm_school'] = $_POST['crm_school'];
//            $data['crm_remarks'] = $_POST['crm_remarks'];
            $data['crm_service_type'] = $_POST['crm_service_type'];
            $data['crm_user_from'] = $_POST['crm_user_from'];
            $data['crm_user_status'] = $_POST['crm_user_status'];
            $data['crm_house_type'] = $_POST['crm_house_type'];
            $data['crm_user_name'] = $_POST['crm_user_name'];
            $data['crm_room_type'] = $_POST['crm_room_type'];
            $data['crm_price_min'] = $_POST['crm_price_min'];
            $data['crm_price_max'] = $_POST['crm_price_max'];
            $data['crm_car_site'] = isset($_POST['crm_car_site'])? 1:0;
            $data['crm_is_star'] = $_POST['crm_is_star'];
            $data['crm_need'] = $_POST['crm_need'];
            $data['crm_user_addtime'] = time();
            $data['crm_update_time'] = time();
//            $data['crm_birthday'] = strtotime($_POST['crm_birthday']);
            $data['crm_live_time'] = strlen(strtotime($_POST['crm_live_time'])) ? strtotime($_POST['crm_live_time']) :'';
            $addBan=Db::table('crm_user')->insertGetId($data);
            if($addBan){
                $alert['alert_time'] = strtotime($_POST['alert_time']);
                $alert['user_id'] = $addBan;
                $alert['alert_remark'] =$_POST['alert_remark'];
                $alert['add_time'] = time();
                $alert['alert_admin'] = $adminId;
                $addInsert = Db::table('crm_user_alert')->insert($alert);
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $service = Db::table('crm_service')->select();
            $this->assign('service',$service);
            $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
            $this->assign('userStatus',$userStatus);
            $houseType = Db::table('crm_house_type')->where(['ht_type' =>1])->select();
            $this->assign('houseType',$houseType);
            $roomType = Db::table('crm_house_type')->where(['ht_type' =>2])->select();
            $this->assign('roomType',$roomType);
            $price = Db::table('crm_house_type')->where(['ht_type' =>3])->select();
            $this->assign('priceRange',$price);
            //客户来源
            $userForm = Db::table('crm_user_form')->select();
            $this->assign('userForm',$userForm);
            //生成用户编号
            $custId = $this->getCustId($adminId);
            $this->assign('custId',$custId);
            return $this->fetch();
        }
    }


    public function alert(){
        $user_id = $_GET['user_id'];
        $alerts = Db::table('crm_user_alert')
            ->join('crm_user','crm_user.crm_user_id = crm_user_alert.user_id')
            ->where(['user_id' => $user_id])
            ->field('crm_user_alert.*,crm_user.crm_user_bid')
            ->select();
        if($alerts){
            foreach ($alerts as $k => $v){
                $alerts[$k]['alert_time'] = date('Y-m-d H:i:s',$v['alert_time']);
                if(!empty($v['alert_admin']) && is_int($v['alert_admin'])){
                    $adInfo=Db::table('super_admin')
                        ->where(['ad_id' => $v['alert_admin']])
                        ->field('ad_id,ad_realname')->find();
                    $adName = $adInfo['ad_realname'];
                }else{
                    $adName="---";
                }
                $alerts[$k]['alert_admin'] = $adName;
            }

        }
        $this->assign('user_id',$user_id);
        $this->assign('alert',$alerts);
        $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
        $this->assign('status',$userStatus);
        return $this->fetch();
    }

    public function getUserIdViaUserBid($userBid){
        $user = Db::table('crm_user')
            ->where(['crm_user_bid' => $userBid])
            ->field('crm_user_id')
            ->find();
        return $user['crm_user_id'];
    }

    public function details(){
        $user_id = trim($this->request->param('user_id','0'));
        $user_bid = trim($this->request->param('user_bid','0'));
        $type = trim($this->request->param('type','0','intval'));
        if($user_bid){
            $user_id = $this->getUserIdViaUserBid($user_bid);
        }
        $alerts = Db::table('crm_user_alert')
            ->join('crm_user','crm_user.crm_user_id = crm_user_alert.user_id')
            ->where(['user_id' => $user_id])
            ->field('crm_user_alert.*,crm_user.crm_user_bid,crm_user.crm_user_addtime,crm_user.crm_order_time')
            ->select();
        $common = new Commons();
        if($alerts){
            foreach ($alerts as $k => $v){
                $alerts[$k]['alert_time'] = date('Y-m-d H:i:s',$v['alert_time']);
                if(!empty($v['alert_admin']) && is_int($v['alert_admin'])){
                    $adInfo=Db::table('super_admin')
                        ->where(['ad_id' => $v['alert_admin']])
                        ->field('ad_id,ad_realname')->find();
                    $adName = $adInfo['ad_realname'];
                }else{
                    $adName="---";
                }
                $alerts[$k]['alert_admin'] = $adName;
            }

        }
        //相关订单

        $userBid = $this->getUserBidViaUserId($user_id);
        //闪电租房
        $orders = Db::table('crm_light')
            ->where("find_in_set('".$userBid."',cl_user_ids)")
            ->field('cl_id,cl_order_id,cl_add_time,cl_order_status')
            ->select();
        foreach ($orders as $k => $v){
            $orders[$k]['cl_order_status'] = $common->getClOrderStatus($v['cl_order_status']);
        }
        //看房，领钥匙，水电气网
        $order = Db::table('crm_order')
            ->where(['order_user_id' => $userBid])
            ->field('crm_id,order_id,order_step,order_status,order_addtime')
            ->select();
        foreach ($order as $k => $v){
            $order[$k]['order_status'] = $common->getOrderStatus($v['order_status']);
            $order[$k]['order_step'] = $common->getOrderStepById($v['order_step']);
        }
        $this->assign('suborder',$order);
        $this->assign('order',$orders);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        $service = Db::table('crm_service')->select();
        $this->assign('service',$service);
        $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
        $this->assign('userStatus',$userStatus);
        $userInfo = Db::table('crm_user')->where(['crm_user_id' => $user_id])->find();
        $userInfo['crm_user_addtime'] = date('Y-m-d',$userInfo['crm_user_addtime']);
        $userInfo['crm_order_time'] = $userInfo['crm_order_time'] == '0000-00-00 00:00:00' ? "---" : substr($userInfo['crm_order_time'],'0','10');
        $userInfo['crm_order_circle'] = $userInfo['crm_order_time'] == '---' ? "---" : $common->diffBetweenTwoDays($userInfo['crm_user_addtime'],$userInfo['crm_order_time']).'天';
        $houseType = Db::table('crm_house_type')->where(['ht_type' =>1])->select();
        $this->assign('houseType',$houseType);
        $roomType = Db::table('crm_house_type')->where(['ht_type' =>2])->select();
        $this->assign('roomType',$roomType);
        $price = Db::table('crm_house_type')->where(['ht_type' =>3])->select();
        $this->assign('priceRange',$price);
        $userInfo['crm_live_time'] = $userInfo['crm_live_time'] ? date('Y-m-d',$userInfo['crm_live_time']):'';
        $userInfo['crm_birthday'] = $userInfo['crm_birthday'] ? date('Y-m-d',$userInfo['crm_birthday']):'';
        $this->assign('user',$userInfo);
        $this->assign('user_id',$user_id);
        $this->assign('alert',$alerts);
        $this->assign('type',$type);
        $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
        $this->assign('status',$userStatus);
        return $this->fetch();
    }



    public function getUserBidViaUserId($uid){
        $user = Db::table('crm_user')
            ->where(['crm_user_id' => $uid])
            ->field('crm_user_bid')
            ->find();
        return $user ? $user['crm_user_bid'] :'';
    }

    public function addAlert(){
        $adminId = session('adminId');
        $alert['user_id'] =intval(trim($_POST['user_id']));
        $alert['alert_time'] =strtotime(trim($_POST['alert_time']));
        $alert['alert_remark']=trim($_POST['alert_remark']);
        $alert['alert_admin'] = $adminId;
        $newAlert = Db::table('crm_user_alert')->insert($alert);
        $userID = intval(trim($_POST['user_id']));
        $status['crm_user_status'] = intval(trim($_POST['cus_status']));
        Db::table('crm_user')->where(['crm_user_id' =>$userID])->update($status);
        if($newAlert){
            $this->success('添加成功！');
        }else{
            $this->error('添加失败！');
        }
    }


    //生成用户编号
    public function getCustId($adminId){
        //C开头；
        $custId = 'C';
        //工作人员员工编号工号后三位
        $cusBid = $this->getAdminBid($adminId);
        $custId .=sprintf("%03d", $cusBid);
        //年份的后三位+月份和日期
        $date = substr(date('Ymd'),'1');
        $custId .=$date;
        //获取当日预约的数量+月份和日期
        $stime=strtotime(date('Y-m-d 00:00:00'));
        $etime=strtotime(date('Y-m-d 23:59:59'));
        $buNum=Db::table('crm_user')
            ->where(['crm_user_admin' => $adminId])
            ->where('crm_user_addtime','between',[$stime,$etime])
            ->count();
        $custId .=sprintf("%03d", $buNum+1);
        return $custId;
    }


    public function getAdminBid($adminId){
        $adminInfo = Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_bid')->find();
        $adBid = substr($adminInfo['ad_bid'],-3);
        return $adBid;
    }


    public function checkWechat(){
        $user_id = $_POST['user_id'];
        $crm_wechat = $_POST['crm_wechat'];
        if($user_id){
            $isRepeat=Db::table('crm_user')
                ->where('crm_user_id','neq',$user_id)
                ->where(['crm_wechat' => $crm_wechat])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此微信号已存在！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此微信号经系统检测可用。';
            }
        }else{
            $isRepeat=Db::table('crm_user')->where(['crm_wechat' => $crm_wechat])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此微信号已注册！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此微信号经系统检测可用。';
            }
        }
        return $res;
    }


    public function delUser(){
        $cus_id = intval(trim($_GET['cus_id']));
        Db::table('crm_user_alert')->where(['user_id' => $cus_id])->delete();
        $del = Db::table('crm_user')->where(['crm_user_id' => $cus_id])->delete();
        if($del){
            $this->success('删除成功','index');
        }else{
            $this->error('删除失败','index');
        }
    }

    public function edit(){
        $adminId = session('adminId');
        $cus_id = intval(trim($_GET['user_id']));
        if($_POST){
            $data['crm_wechat'] = $_POST['crm_wechat'];
            $isRepeat=Db::table('crm_user')
                ->where('crm_user_id','neq',$cus_id)
                ->where(['crm_wechat' => $data['crm_wechat']])
                ->find();
            if($isRepeat){
                $this->error('此微信号已注册！','index');
            }
            $data['crm_user_admin'] = $adminId;
//            $data['crm_sex'] = $_POST['crm_sex'];
            $data['crm_refer'] = $_POST['crm_refer'];
            $data['crm_phone'] = $_POST['crm_phone'];
            $data['crm_city'] = $_POST['crm_city'];
            $data['crm_school'] = $_POST['crm_school'];
//            $data['crm_remarks'] = $_POST['crm_remarks'];
            $data['crm_service_type'] = $_POST['crm_service_type'];
            $data['crm_house_type'] = $_POST['crm_house_type'];
            $data['crm_user_name'] = $_POST['crm_user_name'];
            $data['crm_room_type'] = $_POST['crm_room_type'];
            $data['crm_price_min'] = $_POST['crm_price_min'];
            $data['crm_price_max'] = $_POST['crm_price_max'];
            $data['crm_car_site'] = isset($_POST['crm_car_site'])? 1:0;
            $data['crm_user_from'] = $_POST['crm_user_from'];
            $data['crm_user_status'] = $_POST['crm_user_status'];
            $data['crm_is_star'] = $_POST['crm_is_star'];
            $data['crm_need'] = $_POST['crm_need'];
            $data['crm_update_time'] = time();
//            $data['crm_birthday'] = strtotime($_POST['crm_birthday']);
            $data['crm_live_time'] = strlen(strtotime($_POST['crm_live_time'])) ? strtotime($_POST['crm_live_time']) :'';
            $edit=Db::table('crm_user')->where(['crm_user_id'=>$cus_id])->update($data);
            if($edit){
                $this->success('修改成功','index');
            }else{
                $this->error('修改失败','index');
            }
        }else{
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $service = Db::table('crm_service')->select();
            $this->assign('service',$service);
            $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
            $this->assign('userStatus',$userStatus);
            $userInfo = Db::table('crm_user')->where(['crm_user_id' => $cus_id])->find();
            $houseType = Db::table('crm_house_type')->where(['ht_type' =>1])->select();
            $this->assign('houseType',$houseType);
            $roomType = Db::table('crm_house_type')->where(['ht_type' =>2])->select();
            $this->assign('roomType',$roomType);
            $price = Db::table('crm_house_type')->where(['ht_type' =>3])->select();
            $this->assign('priceRange',$price);
            $userInfo['crm_live_time'] = $userInfo['crm_live_time'] ? date('Y-m-d',$userInfo['crm_live_time']):'';
            $userInfo['crm_birthday'] = $userInfo['crm_birthday'] ? date('Y-m-d',$userInfo['crm_birthday']):'';
            $this->assign('user',$userInfo);
            return $this->fetch();
        }
    }



    public function formuser(){
        return $this->fetch();
    }


    public function formData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        $where=" type = 1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( fu_phone = '".$keywords."')";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=strtotime(substr($live_time,'0','10')." 00:00:00");
            $edate=strtotime(substr($live_time,'-10')." 23:59:59");
            $where.=" and ( fu_addtime >= ".$sdate." and fu_addtime <= ".$edate." ) ";
        }
        $count=Db::table('crm_form_user')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_form_user')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('status desc,fu_addtime asc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['fu_addtime']= date('Y-m-d H:i:s',$v['fu_addtime']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    public function upinfo(){
        $fu_id = intval(trim($this->request->param('fu_id')));
        if($_POST){
            $b_id = session('ad_bid');
            $data['remarks'] = $_POST['remarks'];
            $data['admin'] = $b_id;
            $data['update_time'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $update = Db::table('crm_form_user')
                ->where(['fu_id' => $fu_id])
                ->update($data);
            if($update){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $user = Db::table('crm_form_user')
                ->where(['fu_id' => $fu_id])
                ->find();
            $user['fu_addtime']= date('Y-m-d H:i:s',$user['fu_addtime']);
            $this->assign('user',$user);
            return $this->fetch();
        }
    }



    public function recom(){
        return $this->fetch();
    }

    public function recomData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        $where="type = 2";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( fu_phone = '".$keywords."')";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=strtotime(substr($live_time,'0','10')." 00:00:00");
            $edate=strtotime(substr($live_time,'-10')." 23:59:59");
            $where.=" and ( fu_addtime >= ".$sdate." and fu_addtime <= ".$edate." ) ";
        }
        $count=Db::table('crm_form_user')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_form_user')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('status desc,fu_addtime asc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['fu_addtime']= date('Y-m-d H:i:s',$v['fu_addtime']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }
}